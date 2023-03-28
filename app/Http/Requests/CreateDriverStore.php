<?php

namespace App\Http\Requests;

use App\Rules\IsOldDriver;
use Illuminate\Foundation\Http\FormRequest;

class CreateDriverStore extends FormRequest
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
            'src_img' => 'nullable|url',
            'first_name' => 'required|min:3|max:100',
            'last_name' => 'required|min:3|max:100',
            'birthday' => [
                'required',
                'date',
                new IsOldDriver()
            ]
        ];
    }
}
