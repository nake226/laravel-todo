<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id)
    {

        // フォルダーの取得
        $folders = Folder::all();

        // 選択中のフォルダー
        $current_folder = Folder::find($id);

        // フォルダに紐づくタスクの取得
        $tasks = Task::where('folder_id', $current_folder->id)->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks
        ]);
    }
}
