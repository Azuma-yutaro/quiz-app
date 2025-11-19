<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 管理画面TOP、カテゴリー一覧表示
     */
    public function top()
    {
        // カテゴリー一覧を取得
        $categories = Category::get();
        // dd($categories);

        return view('admin.top',[
            'categories' =>$categories
        ]);
    }

    /**
     * カテゴリー新規登録表示
     */
    public function create()
    {
         return view('admin.categories.create');
    }

    /**
     * カテゴリー新規登録処理
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();

        $category->name        = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.top');

    }

    /**
     * カテゴリー詳細表示
     */
    public function show(Request $request,int $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        return view('admin.categories.show',[
            'category' =>$category
        ]);

    }

    /**
     * カテゴリー編集画面
     */
    public function edit(Request $request,int $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.edit',[
            'category' =>$category
        ]);
    }

    /**
     * カテゴリー更新
     */
    public function update(UpdateCategoryRequest $request, int $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->name        = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.categories.show',['categoryId' => $categoryId]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
