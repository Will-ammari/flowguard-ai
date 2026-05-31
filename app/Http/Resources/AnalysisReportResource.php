<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalysisReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'workflow_id' => $this->workflow_id,
            'overall_risk_level' => $this->overall_risk_level,
            'summary' => $this->summary,
            'report_payload' => $this->report_payload,
            'created_at' => optional($this->created_at)->toISOString(),
        ];
    }
}
