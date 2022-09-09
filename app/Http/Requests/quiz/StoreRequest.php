<?php

namespace App\Http\Requests\quiz;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'picture' => 'required|image|mimes:jpg,png,jpeg',
            'description' => "required|max:400",
            'per_question_mark' => "required|max:100",
            'time' => "required",
            'number_of_taken' => "required|max:100",
            'is_time_questions' => "required",
        ];
    }
}
