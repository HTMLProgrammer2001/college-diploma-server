<?php

namespace App\Http\Requests\Education;

use Illuminate\Foundation\Http\FormRequest;

class AddEducationRequest extends FormRequest
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
            'institution' => 'required|string',
            'graduateYear' => 'required|numeric',
            'qualification' => 'required|numeric',
            'user' => 'required|numeric|exists:users,id',
            'specialty' => 'nullable|string'
        ];
    }
}
