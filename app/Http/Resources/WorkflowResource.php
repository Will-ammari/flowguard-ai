<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'industry' => $this->industry,
            'owner_name' => $this->owner_name,
            'business_context' => $this->business_context,
            'steps' => WorkflowStepResource::collection($this->whenLoaded('steps')),
            'risk_findings' => RiskFindingResource::collection($this->whenLoaded('riskFindings')),
            'created_at' => optional($this->created_at)->toISOString(),
            'updated_at' => optional($this->updated_at)->toISOString(),
        ];
    }
}
