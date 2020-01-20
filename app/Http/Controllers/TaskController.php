<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;

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
    public function create(int $id, CreateTask $request)
    {
        // 現在のフォルダー
        $current_folder = Folder::find($id);
        // タスクのインスタンス作成
        $task = new Task();
        // タイトル
        $task->title = $request->title;
        // 期限
        $task->due_date = $request->due_date;
        // タスクの保存、tasks()はFolderクラスのメソッド
        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    /**
     * タスク編集画面への遷移
     */
    public function showEditForm(int $task_id)
    {
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * タスク編集後、更新
     */
    public function edit(int $task_id, EditTask $request)
    {
        // 更新するタスク
        $task = Task::find($task_id);

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
