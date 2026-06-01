<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowStepResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'workflow_id' => $this->workflow_id,
            'step_order' => $this->step_order,
            'name' => $this->name,
            'step_type' => $this->step_type,
            'description' => $this->description,
            'input_data' => $this->input_data,
            'output_data' => $this->output_data,
            'systems_involved' => $this->systems_involved,
            'flags' => [
                'uses_ai' => $this->uses_ai,
                'uses_personal_data' => $this->uses_personal_data,
                'has_human_review' => $this->has_human_review,
                'is_customer_facing' => $this->is_customer_facing,
                'uses_external_api' => $this->uses_external_api,
                'stores_data' => $this->stores_data,
                'uses_sensitive_data' => $this->uses_sensitive_data,
                'has_audit_log' => $this->has_audit_log,
                'has_fallback_path' => $this->has_fallback_path,
                'is_irreversible_action' => $this->is_irreversible_action,
            ],
        ];
    }
}