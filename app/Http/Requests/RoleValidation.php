<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleValidation extends FormRequest
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
            'role'        => 'required|string|min:3|max:20',
            'description' => 'required|string|min:3|max:100'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'role.required'        => 'Isian harus terisi.',
            'role.string'          => 'Isian harus huruf.',
            'role.min'             => 'Isian minimal 3 huruf.',
            'role.max'             => 'Isian maksimal 8 huruf.',
            'description.required' => 'Isian harus terisi.',
            'description.string'   => 'Isian harus huruf.',
            'description.min'      => 'Isian minimal 3 huruf.',
            'description.max'      => 'Isian maksimal 100 huruf.'
        ];
    }
}
