<?php

namespace App\Http\Requests\UserActions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditMeRequest extends FormRequest
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
        $user = auth('api')->user();

        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'password' => 'nullable|between:8,32|confirmed',
            'phone' => 'nullable|string',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image'
        ];
    }
}
