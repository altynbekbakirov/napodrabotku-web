<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestiontest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question_kg'=>'required|min:2',
            'question_ru'=>'required|min:2',
            'answer_kg[]'=>'required|min:2',
            'answer_ru[]'=>'required|min:2',
        ];
    }
}
