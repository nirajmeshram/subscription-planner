<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComboPlanRequest extends FormRequest
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
        $ComboPlanId = $this->route('combo_plan');

        return [
            'name' => [
                'required',
                'string',
                Rule::unique('combo_plans')->ignore($ComboPlanId),
            ],
            'price' => ['required', 'numeric'],
            'plans' => ['required']
        ];
    }
}
