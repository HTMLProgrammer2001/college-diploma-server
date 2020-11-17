<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AllUserRequest extends FormRequest
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
            'filterName' => 'nullable|string',
            'filterEmail' => 'nullable|string',
            'filterCommission' => 'nullable|numeric|exists:commissions,id',
            'filterDepartment' => 'nullable|numeric|exists:departments,id',
            'filterRank' => 'nullable|numeric|exists:ranks,id',
            'filterTitle' => 'nullable|numeric',
            'filterCategory' => 'nullable|numeric'
        ];
    }
}
