<?php

namespace App\Http\Requests\Publication;

use Illuminate\Foundation\Http\FormRequest;

class AddPublicationRequest extends FormRequest
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
            'url' => 'nullable|url',
            'publisher' => 'nullable|string',
            'date' => 'nullable|date',
            'authors' => 'required|array',
            'another_authors' => 'nullable|string'
        ];
    }
}
