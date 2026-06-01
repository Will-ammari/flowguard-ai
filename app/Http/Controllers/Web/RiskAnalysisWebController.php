<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Workflow;
use App\Services\Audit\AuditLogger;
use App\Services\Risk\RiskAnalyzer;
use Illuminate\Http\Request;

class RiskAnalysisWebController extends Controller
{
    public function analyze(Request $request, Workflow $workflow, RiskAnalyzer $riskAnalyzer, AuditLogger $auditLogger)
    {
        $result = $riskAnalyzer->analyze($workflow);

        $auditLogger->workflowAnalyzed($workflow, $request, [
            'source' => 'web',
            'overall_risk_level' => $result['overall_risk_level'],
            'findings_count' => $result['findings']->count(),
            'report_id' => $result['report']->id,
        ]);

        return redirect()
            ->route('workflows.show', $workflow)
            ->with(
                'success',
                'Risk analysis completed. Overall risk level: '.$result['overall_risk_level']
            );
    }
}