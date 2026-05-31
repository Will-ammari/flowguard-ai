<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Workflow;

class DataFlowWebController extends Controller
{
    public function show(Workflow $workflow)
    {
        $workflow->load([
            'steps',
            'riskFindings.workflowStep',
        ]);

        $dataCategories = $this->collectUniqueValues($workflow, 'input_data');
        $outputCategories = $this->collectUniqueValues($workflow, 'output_data');
        $systems = $this->collectUniqueValues($workflow, 'systems_involved');

        $summary = [
            'ai_steps_count' => $workflow->steps->where('uses_ai', true)->count(),
            'personal_data_steps_count' => $workflow->steps->where('uses_personal_data', true)->count(),
            'external_api_steps_count' => $workflow->steps->where('uses_external_api', true)->count(),
            'customer_facing_steps_count' => $workflow->steps->where('is_customer_facing', true)->count(),
            'human_review_steps_count' => $workflow->steps->where('has_human_review', true)->count(),
            'audit_logged_steps_count' => $workflow->steps->where('has_audit_log', true)->count(),
            'fallback_steps_count' => $workflow->steps->where('has_fallback_path', true)->count(),
        ];

        return view('data_flow.show', [
            'workflow' => $workflow,
            'dataCategories' => $dataCategories,
            'outputCategories' => $outputCategories,
            'systems' => $systems,
            'summary' => $summary,
        ]);
    }

    private function collectUniqueValues(Workflow $workflow, $field)
    {
        return $workflow->steps
            ->flatMap(function ($step) use ($field) {
                $values = $step->{$field};

                if (!is_array($values)) {
                    return [];
                }

                return $values;
            })
            ->filter()
            ->unique()
            ->values();
    }
}