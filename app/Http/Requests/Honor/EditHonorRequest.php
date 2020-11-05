<?php

namespace App\Http\Requests\Honor;

use Illuminate\Foundation\Http\FormRequest;

class EditHonorRequest extends FormRequest
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
            'date' => 'required|date',
            'user' => 'required|exists:users,id',
            'type' => 'required|numeric'
        ];
    }
}
