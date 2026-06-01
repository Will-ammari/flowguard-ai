<?php

namespace App\Http\Controllers\Web;

use App\Enums\StepType;
use App\Http\Controllers\Controller;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use App\Services\Audit\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WorkflowStepWebController extends Controller
{
    public function create(Workflow $workflow)
    {
        $nextStepOrder = ((int) $workflow->steps()->max('step_order')) + 1;

        return view('workflow_steps.create', [
            'workflow' => $workflow,
            'stepTypes' => StepType::values(),
            'nextStepOrder' => $nextStepOrder,
        ]);
    }

    public function store(Request $request, Workflow $workflow, AuditLogger $auditLogger)
    {
        $validated = $this->validateStep($request, $workflow);

        $workflowStep = $workflow->steps()->create($this->buildStepPayload($validated, $request));

        $auditLogger->created($workflowStep, $workflow, $request, [
            'source' => 'web',
        ]);

        $this->clearAnalysisResults($workflow);

        return redirect()
            ->route('workflows.show', $workflow)
            ->with('success', 'Workflow step added successfully. Run analysis again to refresh findings.');
    }

    public function edit(Workflow $workflow, WorkflowStep $workflowStep)
    {
        $this->ensureStepBelongsToWorkflow($workflow, $workflowStep);

        return view('workflow_steps.edit', [
            'workflow' => $workflow,
            'workflowStep' => $workflowStep,
            'stepTypes' => StepType::values(),
        ]);
    }

    public function update(Request $request, Workflow $workflow, WorkflowStep $workflowStep, AuditLogger $auditLogger)
    {
        $this->ensureStepBelongsToWorkflow($workflow, $workflowStep);

        $validated = $this->validateStep($request, $workflow, $workflowStep);

        $oldValues = $workflowStep->only([
            'step_order',
            'name',
            'step_type',
            'description',
            'input_data',
            'output_data',
            'systems_involved',
            'uses_ai',
            'uses_personal_data',
            'has_human_review',
            'is_customer_facing',
            'uses_external_api',
            'stores_data',
            'uses_sensitive_data',
            'has_audit_log',
            'has_fallback_path',
            'is_irreversible_action',
        ]);

        $workflowStep->update($this->buildStepPayload($validated, $request));

        $auditLogger->updated($workflowStep, $oldValues, $workflow, $request, [
            'source' => 'web',
        ]);

        $this->clearAnalysisResults($workflow);

        return redirect()
            ->route('workflows.show', $workflow)
            ->with('success', 'Workflow step updated successfully. Run analysis again to refresh findings.');
    }

    public function destroy(Request $request, Workflow $workflow, WorkflowStep $workflowStep, AuditLogger $auditLogger)
    {
        $this->ensureStepBelongsToWorkflow($workflow, $workflowStep);

        $auditLogger->deleted($workflowStep, $workflow, $request, [
            'source' => 'web',
        ]);

        $workflowStep->delete();

        $this->clearAnalysisResults($workflow);

        return redirect()
            ->route('workflows.show', $workflow)
            ->with('success', 'Workflow step deleted successfully. Run analysis again to refresh findings.');
    }

    private function validateStep(Request $request, Workflow $workflow, WorkflowStep $workflowStep = null)
    {
        $stepId = $workflowStep ? $workflowStep->id : null;

        return $request->validate([
            'step_order' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('workflow_steps', 'step_order')
                    ->where('workflow_id', $workflow->id)
                    ->ignore($stepId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'step_type' => ['required', 'string', Rule::in(StepType::values())],
            'description' => ['nullable', 'string'],
            'input_data' => ['nullable', 'string'],
            'output_data' => ['nullable', 'string'],
            'systems_involved' => ['nullable', 'string'],
        ]);
    }

    private function buildStepPayload(array $validated, Request $request)
    {
        return [
            'step_order' => $validated['step_order'],
            'name' => $validated['name'],
            'step_type' => $validated['step_type'],
            'description' => isset($validated['description']) ? $validated['description'] : null,
            'input_data' => $this->csvToArray(isset($validated['input_data']) ? $validated['input_data'] : null),
            'output_data' => $this->csvToArray(isset($validated['output_data']) ? $validated['output_data'] : null),
            'systems_involved' => $this->csvToArray(isset($validated['systems_involved']) ? $validated['systems_involved'] : null),

            'uses_ai' => $request->boolean('uses_ai'),
            'uses_personal_data' => $request->boolean('uses_personal_data'),
            'has_human_review' => $request->boolean('has_human_review'),
            'is_customer_facing' => $request->boolean('is_customer_facing'),
            'uses_external_api' => $request->boolean('uses_external_api'),
            'stores_data' => $request->boolean('stores_data'),
            'uses_sensitive_data' => $request->boolean('uses_sensitive_data'),
            'has_audit_log' => $request->boolean('has_audit_log'),
            'has_fallback_path' => $request->boolean('has_fallback_path'),
            'is_irreversible_action' => $request->boolean('is_irreversible_action'),
        ];
    }

    private function csvToArray($value)
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return collect(explode(',', $value))
            ->map(function ($item) {
                return trim($item);
            })
            ->filter()
            ->values()
            ->all();
    }

    private function ensureStepBelongsToWorkflow(Workflow $workflow, WorkflowStep $workflowStep)
    {
        if ((int) $workflowStep->workflow_id !== (int) $workflow->id) {
            abort(404);
        }
    }

    private function clearAnalysisResults(Workflow $workflow)
    {
        $workflow->riskFindings()->delete();
        $workflow->reports()->delete();
    }
}