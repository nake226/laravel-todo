<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    // タスクとの関連づけ
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
