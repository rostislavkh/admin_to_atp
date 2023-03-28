<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBus extends FormRequest
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
            'number' => 'required|max:8|min:8',
            'driver' => 'nullable|numeric|exists:drivers,id',
            'brand' => 'required|numeric|exists:car_brands,id',
        ];
    }
}
