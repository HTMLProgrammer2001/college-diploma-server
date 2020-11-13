<?php

namespace App\Http\Requests\Qualifications;

use Illuminate\Foundation\Http\FormRequest;

class AddQualificationRequest extends FormRequest
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
            'user' => 'required|numeric|exists:users,id',
            'date' => 'required|date',
            'name' => 'required|numeric',
            'description' => 'nullable|string'
        ];
    }
}
