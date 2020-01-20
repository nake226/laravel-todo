<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\Http\Requests\createTask;

class TaskController extends Controller
{
    public function index(int $id)
    {

        // フォルダーの取得
        $folders = Folder::all();

        // 選択中のフォルダー
        $current_folder = Folder::find($id);

        // フォルダに紐づくタスクの取得
        $tasks = $current_folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks
        ]);
    }

    /**
     * タスクの新規作成
     */
    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    /**
     * タスクの作成、保存をした後にタスク一覧へリダイレクト
     */
    public function create(createTask $request)
    {
        // タスクのインスタンス作成
        $task = new Task();
        // タイトル
        $task->title = $request->title;
        // 期限
        $task->due_date = $request->due_date;
        // 作成したインスタンスをDBに保存
        $task->save();

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}
