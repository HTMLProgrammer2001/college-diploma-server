<?php

namespace App\Http\Requests\Rebuke;

use Illuminate\Foundation\Http\FormRequest;

class AllRebukeRequest extends FormRequest
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
            'sort' => 'nullable|array',
            'filterUser' => 'nullable|exists:users,id',
            'filterTitle' => 'nullable|string',
            'filterFrom' => 'nullable|date',
            'filterTo' => 'nullable|date',
            'filterType' => 'nullable|numeric'
        ];
    }
}
