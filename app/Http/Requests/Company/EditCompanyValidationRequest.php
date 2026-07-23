<?php

namespace App\Http\Requests\Company;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditCompanyValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:companies,name,' . $this->route('companies'),
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_password' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The company name field is required.',
            'name.unique' => 'The company name has already been taken.',
            'name.string' => 'The company name must be a string.',
            'name.max' => 'The company name may not be greater than 255 characters.',
            'address.required' => 'The company address field is required.',
            'address.string' => 'The company address must be a string.',
            'address.max' => 'The company address may not be greater than 255 characters.',
            'industry.required' => 'The company industry field is required.',
            'website.url' => 'The company website must be a valid URL.',
            'website.max' => 'The company website may not be greater than 255 characters.',
            'owner_name.required' => 'The owner name field is required.',
            'owner_name.string' => 'The owner name must be a string.',
            'owner_name.max' => 'The owner name may not be greater than 255 characters.',
            'owner_password.string' => 'The owner password must be a string.',
        ];
    }
}
