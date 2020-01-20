<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Validation\Rule;

class EditTask extends CreateTask
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // バリデーションルールの継承
        $rule = parent::rules();

        $status_rule = Rule::in(array_keys(Task::STATUS));

        return $rule + [
            'status' => 'required|' . $status_rule,
        ];
    }

    public function attributes()
    {
        // 表記の継承
        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態',
        ];
    }

    public function messages()
    {
        // メッセージの継承
        $messages = parent::messages();

        $status_labels = array_map(function ($item) {
            return $item['label'];
        }, Task::STATUS);

        // 状態の表記の連結
        $status_labels = implode('、', $status_labels);

        return $messages + [
            'status.in' => ':attribute には ' . $status_labels . 'のいずれかを指定してください'
        ];
    }
}
