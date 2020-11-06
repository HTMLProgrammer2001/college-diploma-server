<?php

namespace App\Http\Requests\Rebuke;

use Illuminate\Foundation\Http\FormRequest;

class EditRebukeRequest extends FormRequest
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
            'title' => 'required|string',
            'order' => 'required|string',
            'datePresentation' => 'required|date',
            'user' => 'required|exists:users,id'
        ];
    }
}
