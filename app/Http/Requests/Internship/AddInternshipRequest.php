<?php

namespace App\Http\Requests\Internship;

use Illuminate\Foundation\Http\FormRequest;

class AddInternshipRequest extends FormRequest
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
            'category' => 'required|numeric|exists:internship_categories,id',
            'title' => 'required|string',
            'from' => 'required|date',
            'to' => 'required|date',
            'place' => 'nullable|string',
            'hours' => 'required|numeric|between:0,200',
            'credits' => 'nullable|numeric|between:0,200',
            'code' => 'nullable|string'
        ];
    }
}
