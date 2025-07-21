<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobVacancyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   public function authorize(): bool
    {
        // Gunakan helper method jika ada
        return $this->user()->isAdmin() || $this->user()->isHRD();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|in:full-time,part-time,contract,internship',
            'salary_range' => 'nullable|string|max:255',
            'quota' => 'required|integer|min:1',
            'status' => 'required|string|in:active,closed',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'stages' => 'required|array|min:1|max:5',
            'stages.*.name' => 'required|string|max:255',
            'stages.*.description' => 'nullable|string|max:255',
        ];
    }
}