<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EligibilityCriteriaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('eligibility_criterion');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('eligibility_criterias')->ignore($id),
            ],
            'age_less_than' => ['required', 'integer', 'min:1', 'max:150', 'gt:age_greater_than'],
            'age_greater_than' => ['required', 'integer', 'min:1', 'max:150', 'lt:age_less_than'],
            'last_login_days_ago' => ['required', 'integer', 'min:0'],
            'income_less_than' => ['required', 'numeric', 'min:0', 'gt:income_greater_than'],
            'income_greater_than' => ['required', 'numeric', 'min:0', 'lt:income_less_than'],
        ];
    }
}
