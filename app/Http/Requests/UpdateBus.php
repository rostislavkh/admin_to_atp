<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBus extends FormRequest
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
            'model.number' => 'required|max:8|min:8',
            'model.driver' => 'nullable|numeric|exists:drivers,id',
            'model.brand' => 'required|numeric|exists:car_brands,id',
        ];
    }
}
