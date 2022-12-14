<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;
use App\User; // 追加

use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }
   
   private function checkMyData(Task$task){
       if($task->user_id != Auth::user()->id){
           return redirect()->route('tasks.index');
       }
   }
   
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {

        $tasks = Auth::user() -> tasks;
        return view('tasks.index',compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function allindex()
    {

        // タスク一覧を取得
        $tasks = Task::all();
  
        return view('tasks.allindex', ['tasks' => $tasks]);

    }
    

    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
         // バリデーション
        $request->validate([
            'content' => 'required',
            'status' => 'required|max:10',   // 追加
        ]);
        
        // タスクを作成
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->user_id = Auth::user()->id;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     
    // getでtasks/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        
    // idの値でタスクを検索して取得
    $task = Task::findOrFail($id);

    // タスク詳細ビューでそれを表示
    // ログインユーザー = タスク作成者なら編集画面へ
    if (\Auth::id() === $task->user_id) {  
    return view('tasks.show', [
    'task' => $task,
        ]);
    }
    return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    // getでtasks/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {

    // idの値でタスクを検索して取得
    $task = Task::findOrFail($id);

    // タスク編集ビューでそれを表示
    // ログインユーザー = タスク作成者なら編集画面へ
    if (\Auth::id() === $task->user_id) {
        return view('tasks.edit', [
        'task' => $task,
        ]);
    }
    // 編集画面に入れなかった場合はトップページへ
        return redirect('/');
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    // putまたはpatchでtasks/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        
    // バリデーション
    $request->validate([
    'content' => 'required',
    'status' => 'required|max:10',   // 追加
        ]);
        
    // idの値でタスクを検索して取得
    $task = Task::findOrFail($id);
    
    // タスクを更新
    // ログインユーザー = タスク作成者なら編集処理へ
    if (\Auth::id() === $task->user_id) {
        $task->content = $request->content;
        $task->status = $request->status;    // 追加
        $task->save();
    }
    // トップページへリダイレクトさせる
        return redirect('/');
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    // deleteでtasks/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {

        
    // idの値でタスクを検索して取得
    $task = Task::findOrFail($id);
   
     // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
    if (\Auth::id() === $task->user_id) {
       
    // タスクを削除
    $task->delete();
    }
    // トップページへリダイレクトさせる
    return redirect('/');
    }
}
