<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Workflow;
use App\Services\Risk\RiskAnalyzer;

class RiskAnalysisWebController extends Controller
{
    public function analyze(Workflow $workflow, RiskAnalyzer $riskAnalyzer)
    {
        $result = $riskAnalyzer->analyze($workflow);

        return redirect()
            ->route('workflows.show', $workflow)
            ->with(
                'success',
                'Risk analysis completed. Overall risk level: '.$result['overall_risk_level']
            );
    }
}