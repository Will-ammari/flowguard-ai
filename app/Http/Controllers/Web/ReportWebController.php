<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Workflow;

class ReportWebController extends Controller
{
    public function show(Workflow $workflow)
    {
        $workflow->load([
            'steps',
            'riskFindings.workflowStep',
            'reports',
        ]);

        $latestReport = $workflow->reports()
            ->latest()
            ->first();

        if (!$latestReport) {
            return redirect()
                ->route('workflows.show', $workflow)
                ->with('error', 'No analysis report exists yet. Run analysis first.');
        }

        $findingsByLevel = $workflow->riskFindings
            ->groupBy('risk_level')
            ->map(function ($items) {
                return $items->count();
            });

        $findingsByCategory = $workflow->riskFindings
            ->groupBy('risk_category')
            ->map(function ($items) {
                return $items->count();
            })
            ->sortDesc();

        $findingsByControlStatus = $workflow->riskFindings
            ->groupBy('control_status')
            ->map(function ($items) {
                return $items->count();
            });

        $maxRiskScore = (int) $workflow->riskFindings->max('risk_score');
        $averageRiskScore = $workflow->riskFindings->count() > 0
            ? round($workflow->riskFindings->avg('risk_score'), 2)
            : 0;

        return view('reports.show', [
            'workflow' => $workflow,
            'latestReport' => $latestReport,
            'findingsByLevel' => $findingsByLevel,
            'findingsByCategory' => $findingsByCategory,
            'findingsByControlStatus' => $findingsByControlStatus,
            'maxRiskScore' => $maxRiskScore,
            'averageRiskScore' => $averageRiskScore,
        ]);
    }
}
