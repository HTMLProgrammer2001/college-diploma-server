<?php

namespace App\Http\Requests\Internship;

use Illuminate\Foundation\Http\FormRequest;

class AllInternshipsRequest extends FormRequest
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
            'filterUser' => 'nullable|numeric|exists:users,id',
            'filterCategory' => 'nullable|numeric|exists:internship_categories,id',
            'filterFrom' => 'nullable|date',
            'filterTo' => 'nullable|date',
            'filterTitle' => 'nullable|string',
            'filterHoursMore' => 'nullable|numeric',
            'filterHoursLess' => 'nullable|numeric',
            'rules' => 'nullable|array'
        ];
    }
}
