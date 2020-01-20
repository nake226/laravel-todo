<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100',
            'due_date' => 'required|date|after_or_equal:today',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タスク名',
            'due_date' => '期限',
        ];
    }

    /**
     * タスク作成時のみ適用する個別ルール
     * 左辺にkey.ruleの形式で指定する
     */
    public function messages()
    {
        return [
            'due_date.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
        ];
    }
}
