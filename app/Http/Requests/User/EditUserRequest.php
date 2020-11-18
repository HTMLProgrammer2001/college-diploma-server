<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
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
            'fullName' => 'required|string',
            'email' => ['required', 'email'],
            'birthday' => 'nullable|date',
            'phone' => 'nullable|string',
            'password' => 'nullable|string|confirmed',
            'address' => 'nullable|string',
            //'avatar' => 'nullable|image',
            'department' => 'required|numeric|exists:departments,id',
            'commission' => 'required|numeric|exists:commissions,id',
            'rank' => 'nullable|numeric|exists:ranks,id',
            'role' => 'required|numeric',
            'hiring_year' => 'nullable|numeric',
            'pedagogical_title' => 'nullable|numeric',
            'experience' => 'nullable|numeric',
            'academic_status' => 'nullable|numeric',
            'academic_status_year' => 'nullable|numeric',
            'scientific_degree' => 'nullable|numeric',
            'scientific_degree_year' => 'nullable|numeric',
        ];
    }
}
