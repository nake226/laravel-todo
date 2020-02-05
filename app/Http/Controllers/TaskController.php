<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Folder $folder)
    {
        // フォルダーの取得
        $folders = Auth::user()->folders()->get();

        // フォルダに紐づくタスクの取得
        $tasks = $folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks
        ]);
    }

    /**
     * タスクの新規作成
     */
    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder_id' => $folder->id
        ]);
    }

    /**
     * タスクの作成、保存をした後にタスク一覧へリダイレクト
     */
    public function create(Folder $folder, CreateTask $request)
    {
        // タスクのインスタンス作成
        $task = new Task();
        // タイトル
        $task->title = $request->title;
        // 期限
        $task->due_date = $request->due_date;
        // タスクの保存、tasks()はFolderクラスのメソッド
        $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    /**
     * タスク編集画面への遷移
     */
    public function showEditForm(Folder $folder, Task $task)
    {
        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * タスク編集後、更新
     */
    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        // タスクの保存
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}
