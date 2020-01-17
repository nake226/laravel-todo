<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * 状態定義
     */
    const STATUS = [
        1 => ['label' => '未着手'],
        2 => ['label' => '着手中'],
        3 => ['label' => '完了'],
    ];

    public function getStatusLabelAttribute()
    {
        // 状態値
        $status = $this->attributes['status'];

        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        // ステータスに応じた文字列を返す
        return self::STATUS[$status]['label'];
    }
}
