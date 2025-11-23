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


}
