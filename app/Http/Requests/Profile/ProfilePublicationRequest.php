<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePublicationRequest extends FormRequest
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
            'filterTitle' => 'nullable|string',
            'filterFrom' => 'nullable|date',
            'filterTo' => 'nullable|date',
            'sort' => 'nullable|array'
        ];
    }
}
