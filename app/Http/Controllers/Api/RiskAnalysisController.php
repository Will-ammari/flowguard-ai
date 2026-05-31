<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnalysisReportResource;
use App\Http\Resources\RiskFindingResource;
use App\Models\Workflow;
use App\Services\Risk\RiskAnalyzer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RiskAnalysisController extends Controller
{
    public function analyze(Workflow $workflow, RiskAnalyzer $analyzer): JsonResponse
    {
        $result = $analyzer->analyze($workflow);

        return response()->json([
            'workflow_id' => $workflow->id,
            'overall_risk_level' => $result['overall_risk_level'],
            'findings_count' => $result['findings']->count(),
            'report' => new AnalysisReportResource($result['report']),
            'findings' => RiskFindingResource::collection($result['findings']),
        ]);
    }

    public function findings(Workflow $workflow): AnonymousResourceCollection
    {
        return RiskFindingResource::collection(
            $workflow->riskFindings()->with('workflowStep')->latest()->get()
        );
    }
}
