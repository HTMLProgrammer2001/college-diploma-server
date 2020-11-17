<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'commission' => 'required|numeric|exists:commissions,id',
            'department' => 'required|numeric|exists:departments,id'
        ];
    }
}
