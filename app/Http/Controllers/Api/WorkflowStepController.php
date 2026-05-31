<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkflowStepRequest;
use App\Http\Requests\UpdateWorkflowStepRequest;
use App\Http\Resources\WorkflowStepResource;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Http\Response;

class WorkflowStepController extends Controller
{
    public function store(StoreWorkflowStepRequest $request, Workflow $workflow): WorkflowStepResource
    {
        $step = $workflow->steps()->create($request->validated());

        return new WorkflowStepResource($step);
    }

    public function update(UpdateWorkflowStepRequest $request, WorkflowStep $workflowStep): WorkflowStepResource
    {
        $workflowStep->update($request->validated());

        return new WorkflowStepResource($workflowStep->fresh());
    }

    public function destroy(WorkflowStep $workflowStep): Response
    {
        $workflowStep->delete();

        return response()->noContent();
    }
}
