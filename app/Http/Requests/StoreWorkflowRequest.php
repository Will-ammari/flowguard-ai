<?php

namespace App\Http\Requests;

use App\Enums\StepType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkflowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string'],
            'industry' => ['nullable', 'string', 'max:120'],
            'owner_name' => ['nullable', 'string', 'max:120'],
            'business_context' => ['nullable', 'string'],

            'steps' => ['sometimes', 'array'],
            'steps.*.step_order' => ['required_with:steps', 'integer', 'min:1'],
            'steps.*.name' => ['required_with:steps', 'string', 'max:160'],
            'steps.*.step_type' => ['required_with:steps', 'string', Rule::in(StepType::values())],
            'steps.*.description' => ['nullable', 'string'],
            'steps.*.input_data' => ['nullable', 'array'],
            'steps.*.output_data' => ['nullable', 'array'],
            'steps.*.systems_involved' => ['nullable', 'array'],
            'steps.*.uses_ai' => ['boolean'],
            'steps.*.uses_personal_data' => ['boolean'],
            'steps.*.has_human_review' => ['boolean'],
            'steps.*.is_customer_facing' => ['boolean'],
            'steps.*.uses_external_api' => ['boolean'],
            'steps.*.stores_data' => ['boolean'],
            'steps.*.uses_sensitive_data' => ['boolean'],
            'steps.*.has_audit_log' => ['boolean'],
            'steps.*.has_fallback_path' => ['boolean'],
            'steps.*.is_irreversible_action' => ['boolean'],
        ];
    }
}