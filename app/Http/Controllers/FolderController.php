<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\CreateFolder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    /**
     * フォルダの作成、保存をした後にタスク一覧へリダイレクト
     */
    public function create(CreateFolder $request)
    {
        // フォルダのインスタンス作成
        $folder = new Folder();
        // タイトルにフォームの入力値を代入
        $folder->title = $request->title;
        // ユーザーに紐づけて保存
        Auth::user()->folders()->save($folder);

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
