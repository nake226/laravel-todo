<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\createFolder;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    /**
     * フォルダの作成、保存をした後にタスク一覧へリダイレクト
     */
    public function create(createFolder $request)
    {
        // フォルダのインスタンス作成
        $folder = new Folder();
        // タイトルにフォームの入力値を代入
        $folder->title = $request->title;
        // 作成したインスタンスをDBに保存
        $folder->save();

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
