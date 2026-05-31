<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RiskFindingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'workflow_id' => $this->workflow_id,
            'workflow_step_id' => $this->workflow_step_id,
            'risk_code' => $this->risk_code,
            'risk_title' => $this->risk_title,
            'risk_level' => $this->risk_level,
            'risk_category' => $this->risk_category,
            'risk_score' => $this->risk_score,
            'control_status' => $this->control_status,
            'description' => $this->description,
            'recommendation' => $this->recommendation,
            'engineering_control' => $this->engineering_control,
            'metadata' => $this->metadata,
            'created_at' => optional($this->created_at)->toISOString(),
        ];
    }
}
