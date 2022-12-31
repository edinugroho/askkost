<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacilityKostRequest extends FormRequest
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
            'parking' => ['required', 'in:car,motorcycle,car and motorcycle'],
            'bathroom' => ['required', 'in:inside,outside'],
            'security' => ['required', 'in:yes,no'],
            'table' => ['required', 'in:yes,no'],
            'chair' => ['required', 'in:yes,no'],
            'cupboard' => ['required', 'in:yes,no'],
            'bed' => ['required', 'in:yes,no'],
        ];
    }
}
