<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Http\Requests\TodoRequest;
use App\Models\Category;

class TodoController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $todos = Todo::with('category')->simplepaginate(10);
        $categories = Category::all();
        return view('index', compact('user_id','todos', 'categories'));
    }

    public function store(TodoRequest $request){
        $todo = $request->only(['category_id','content']);
        $todo['user_id'] = auth()->user()->id;
        Todo::create($todo);
        return redirect('/')->with('message', 'Todoを作成しました');
    }

    public function update(Request $request){
        $todo = $request->only(['content']);
        Todo::find($request->id)->update($todo);
        return redirect('/')->with('message', 'Todoを更新しました');
    }

    public function destroy(Request $request){
        Todo::find($request->id)->delete();
        return redirect('/')->with('message', 'Todoを削除しました');
    }

    public function search(Request $request){
        $todos = Todo::with('category')->CategorySearch($request->category_id)->KeywordSearch($request->keyword)->simplepaginate(10);
        $user_id = auth()->id();
        $categories = Category::all();

        return view('index', compact('todos', 'categories', 'user_id'));
    }

}
