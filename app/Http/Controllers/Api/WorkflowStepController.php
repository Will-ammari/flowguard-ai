<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkflowStepRequest;
use App\Http\Requests\UpdateWorkflowStepRequest;
use App\Http\Resources\WorkflowStepResource;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use App\Services\Audit\AuditLogger;
use Illuminate\Http\Response;

class WorkflowStepController extends Controller
{
    public function store(StoreWorkflowStepRequest $request, Workflow $workflow, AuditLogger $auditLogger): WorkflowStepResource
    {
        $step = $workflow->steps()->create($request->validated());

        $auditLogger->created($step, $workflow, $request, [
            'source' => 'api',
        ]);

        return new WorkflowStepResource($step);
    }

    public function update(UpdateWorkflowStepRequest $request, WorkflowStep $workflowStep, AuditLogger $auditLogger): WorkflowStepResource
    {
        $workflow = $workflowStep->workflow;

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

        $workflowStep->update($request->validated());

        $auditLogger->updated($workflowStep, $oldValues, $workflow, $request, [
            'source' => 'api',
        ]);

        return new WorkflowStepResource($workflowStep->fresh());
    }

    public function destroy(WorkflowStep $workflowStep, AuditLogger $auditLogger): Response
    {
        $workflow = $workflowStep->workflow;

        $auditLogger->deleted($workflowStep, $workflow, request(), [
            'source' => 'api',
        ]);

        $workflowStep->delete();

        return response()->noContent();
    }
}