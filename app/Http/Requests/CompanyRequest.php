<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'company_name' => 'required|max:32',
            'company_slogan' => 'required|max:255',
            'company_type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => 'Company Name is required.',
            'company_name.max' => 'Company Name cannot be more than 32 characters.',
            'company_slogan.required' => 'Company Slogan is required.',
            'company_slogan.max' => 'Company Slogan cannot be more than 255 characters.',
            'company_type.required' => 'Company Type is required.'
        ];
    }
}
