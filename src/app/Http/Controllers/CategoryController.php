<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('category', compact('categories'));
    }

    public function store(CategoryRequest $request){
        $data = $request->only(['name']);
        Category::create($data);
        return redirect('/categories')->with('message', 'カテゴリを作成しました');
    }

    public function update(CategoryRequest $request){
        $data = $request->only(['name']);
        Category::find($request->id)->update($data);
        return redirect('/categories')->with('message', 'カテゴリを変更しました');
    }

    public function destory(Request $request){
        Category::find($request->id)->delete();
        return redirect('/categories')->with('message', 'カテゴリを削除しました');
    }
}
