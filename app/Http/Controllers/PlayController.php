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
        // dd($request,$categoryId);
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
        // クイズをランダムで選ぶ
        $quizzes = $category->quizzes->toArray();
        shuffle($quizzes);
        // dd($quizzes[0]);
        $quiz = $quizzes[0];

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
        // dd($result);
        return view('play.answer',[
            'isCorrectAnswer' => $isCorrectAnswer,
            'quiz'            => $quiz->toArray(),
            'quizOptions'     => $quizOptions,
            'selectedOptions' => $selectedOptions,
            'categoryId'      => $categoryId
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
