<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverStore extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'model.src_img' => 'nullable|url',
            'model.first_name' => 'required|min:3|max:100',
            'model.last_name' => 'required|min:3|max:100',
            'model.birthday' => 'required|date',
            'model.email' => 'required|email',
            'model.salary' => 'required|numeric'
        ];
    }
}
