<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {
        // ログインユーザーの取得
        $user = Auth::user();

        // ログインユーザーのフォルダを1つ取得
        $folder = $user->folders()->first();

        // フォルダが無ければ作成を促す
        if (is_null($folder)) {
            return view('home');
        }

        // フォルダがあれば、タスク一覧ページへ
        return redirect()->route('tasks.index', [
            'id' => $folder->id
        ]);
    }
}
