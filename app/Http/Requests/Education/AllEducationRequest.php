<?php

namespace App\Http\Requests\Education;

use Illuminate\Foundation\Http\FormRequest;

class AllEducationRequest extends FormRequest
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
            'filterInstitution' => 'nullable|string',
            'filterSpecialty' => 'nullable|string',
            'filterQualification' => 'nullable|string',
            'filterUser' => 'nullable|numeric|exists:users,id',
            'filterGraduateFrom' => 'nullable|numeric',
            'filterGraduateTo' => 'nullable|numeric',
            'rules' => 'nullable|array'
        ];
    }
}
