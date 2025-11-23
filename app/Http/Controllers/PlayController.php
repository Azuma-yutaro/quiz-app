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
        $optionId = $request->optionId;

        return view('play.answer');
    }

}
