<?php

namespace App\Http\Requests;

use App\Enums\StepType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkflowStepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'step_order' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'max:160'],
            'step_type' => ['required', Rule::in(StepType::values())],
            'description' => ['nullable', 'string'],
            'input_data' => ['nullable', 'array'],
            'output_data' => ['nullable', 'array'],
            'systems_involved' => ['nullable', 'array'],
            'uses_ai' => ['boolean'],
            'uses_personal_data' => ['boolean'],
            'has_human_review' => ['boolean'],
            'is_customer_facing' => ['boolean'],
            'uses_external_api' => ['boolean'],
            'stores_data' => ['boolean'],
            'uses_sensitive_data' => ['boolean'],
            'has_audit_log' => ['boolean'],
            'has_fallback_path' => ['boolean'],
            'is_irreversible_action' => ['boolean'],
        ];
    }
}
