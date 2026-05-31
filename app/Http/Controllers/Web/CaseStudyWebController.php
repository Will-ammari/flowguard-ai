<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Demo\DemoWorkflowBuilder;

class CaseStudyWebController extends Controller
{
    public function show(DemoWorkflowBuilder $demoWorkflowBuilder)
    {
        $workflows = $demoWorkflowBuilder->getDemoWorkflows();

        $before = $workflows->firstWhere('title', DemoWorkflowBuilder::BEFORE_TITLE);
        $after = $workflows->firstWhere('title', DemoWorkflowBuilder::AFTER_TITLE);

        return view('case_study.show', [
            'before' => $before,
            'after' => $after,
            'hasDemoData' => $before !== null && $after !== null,
            'comparison' => $this->buildComparison($before, $after),
        ]);
    }

    private function buildComparison($before, $after)
    {
        if (!$before || !$after) {
            return [];
        }

        $beforeReport = $before->reports->sortByDesc('created_at')->first();
        $afterReport = $after->reports->sortByDesc('created_at')->first();

        return [
            'before_risk' => $beforeReport ? $beforeReport->overall_risk_level : 'Not analyzed',
            'after_risk' => $afterReport ? $afterReport->overall_risk_level : 'Not analyzed',
            'before_findings' => $before->riskFindings->count(),
            'after_findings' => $after->riskFindings->count(),
            'before_max_score' => $before->riskFindings->max('risk_score') ?: 0,
            'after_max_score' => $after->riskFindings->max('risk_score') ?: 0,
            'before_missing_controls' => $before->riskFindings->where('control_status', 'Missing')->count(),
            'after_missing_controls' => $after->riskFindings->where('control_status', 'Missing')->count(),
        ];
    }
}