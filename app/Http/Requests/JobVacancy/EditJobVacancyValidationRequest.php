<?php

namespace App\Http\Requests\JobVacancy;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditJobVacancyValidationRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'jobVacancyType' => 'required|string|max:255',
            'companyId' => 'required|string|exists:companies,id',
            'jobCategoryId' => 'required|string|exists:job_categories,id',

        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The job title field is required.',
            'title.string' => 'The job title must be a string.',
            'title.max' => 'The job title may not be greater than 255 characters.',
            'description.required' => 'The job description field is required.',
            'description.string' => 'The job description must be a string.',
            'location.required' => 'The job location field is required.',
            'location.string' => 'The job location must be a string.',
            'location.max' => 'The job location may not be greater than 255 characters.',
            'salary.required' => 'The job salary field is required.',
            'salary.numeric' => 'The job salary must be a number.',
            'salary.min' => 'The job salary must be greater than or equal to 0.',
            'jobVacancyType.required' => 'The job vacancy type field is required.',
            'jobVacancyType.string' => 'The job vacancy type must be a string.',
            'jobVacancyType.max' => 'The job vacancy type may not be greater than 255 characters.',
            'companyId.required' => 'The company field is required.',
            'companyId.exists' => 'The selected company does not exist.',
            'jobCategoryId.required' => 'The category field is required.',
            'jobCategoryId.exists' => 'The selected category does not exist.',

        ];
    }
}
