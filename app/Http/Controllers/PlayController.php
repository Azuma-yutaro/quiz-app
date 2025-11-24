<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class PlayController extends Controller
{
    // プレイヤー画面TOPページ
    public function top(){
        $categories = Category::all();
        return view('play.top',[
            'categories' => $categories
        ]);
    }


    // クイズ画面スタート画面表示
    public function categories(Request $request,int $categoryId){

        // セッション削除
        session()->forget('resultArray');
        $category = Category::withCount('quizzes')->findOrFail($categoryId);

        // dd($category->quizzes_count);

        return view('play.start',
        ['category'    => $category,
        'quizzesCount' => $category->quizzes_count
        ]);
    }

    // クイズ出題画面
    public function quizzes(Request $request,int $categoryId)
    {
        // カテゴリーに紐ずくクイズを取得
        $category = Category::with('quizzes.options')->findOrFail($categoryId);

        // セッションに保存されているクイズIDの配列を取得
        $resultArray = session('resultArray');
        // 初回かどうかを判定
        if(is_null($resultArray)){
            // クイズIDを全て取得
            $quizIds = $category->quizzes->pluck('id')->toArray();
            // クイズIDの配列をランダムに入れ替え
            shuffle($quizIds);

            $resultArray = [];
            foreach ($quizIds as $quizId){
                $resultArray[] = [
                    'quizId' => $quizId,
                    'result' => null,
                ];
            }
            session(['resultArray' => $resultArray]);
        }

        // $resultArrayの中でresultがnullのものを表示
        $noAnswerResult = collect($resultArray)->filter(function ($item) {
            return $item['result'] === null;
        })->first();

        if(!$noAnswerResult){
            // 全てのクイズに回答済み→結果発表画面に遷移
            return redirect()->route('categories.quizzes.result',['categoryId' => $categoryId]);
        }

        // クイズIDに紐ずくクイズを取得
        $quiz = $category->quizzes->firstWhere('id',$noAnswerResult['quizId'])->toArray();

        return view('play.quizzes',[
            'categoryId' => $categoryId,
            'quiz' => $quiz
        ]);
    }

    public function answer(Request $request,int $categoryId) {
        // dd($categoryId,$request);
        $quizId = $request->quizId;
        $selectedOptions = $request->optionId === null ?[] :$request->optionId;

        // カテゴリーに紐ずくクイズを取得
        $category = Category::with('quizzes.options')->findOrFail($categoryId);
        $quiz = $category->quizzes->firstWhere('id',$quizId);
        $quizOptions =$quiz->options->toArray();
        $isCorrectAnswer = $this->isCorrectAnswer($selectedOptions, $quizOptions);

        // セッションからクイズIDと回答情報を取得
        $resultArray = session('resultArray');
        // 回答結果をセッションに保存
        foreach($resultArray as $index =>$result) {
            if($result['quizId'] === (int)$quizId){
                $resultArray[$index]['result'] = $isCorrectAnswer;
                break;
            }
        }
        // 回答結果をセッションに上書きする
        session(['resultArray' => $resultArray]);

        return view('play.answer',[
            'isCorrectAnswer' => $isCorrectAnswer,
            'quiz'            => $quiz->toArray(),
            'quizOptions'     => $quizOptions,
            'selectedOptions' => $selectedOptions,
            'categoryId'      => $categoryId
        ]);
    }



    // 結果画面表示
    public function result(Request $request,int $categoryId){

        // セッションからクイズIDと回答情報を取得
        $resultArray = session('resultArray');
        $questionCount = count($resultArray);
        $correctCount = collect($resultArray)->filter(function ($result) {
            return $result['result'] === true;
        })->count();

        // dd($questionCount,$correctCount);

        return view('play.result',[
            'categoryId' => $categoryId,
            'questionCount' => $questionCount,
            'correctCount' => $correctCount,
        ]);
    }


    // プレイヤーの選択が正解か不正解を判定
    private function isCorrectAnswer(array $selectedOptions,array $quizOptions) {
        // クイズの選択肢から正解の選択肢のIDを取得
        $correctOptions = array_filter($quizOptions,function ($option){
            return $option['is_correct'] === 1;
        });

        // idだけを抽出
        $correctOptionIds = array_map(function($option){
            return $option['id'];
        },$correctOptions);


        // dd($correctOptions,$quizOptions);
        // プレイヤーが選んだ選択肢の個数と成果の選択肢の個数が一致するか判定
        if(count($selectedOptions) !== count($correctOptionIds)){
            return false;
        }
        // 選択肢たIDと正解のIDが一致するか判定

        foreach($selectedOptions as $selectedOption) {
            if(!in_array((int)$selectedOption,$correctOptionIds)){
                return false;
            }
        }

        // 正解
        return true;
    }

}
