<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkflowRequest;
use App\Http\Requests\UpdateWorkflowRequest;
use App\Http\Resources\WorkflowResource;
use App\Models\Workflow;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class WorkflowController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $workflows = Workflow::query()
            ->withCount(['steps', 'riskFindings'])
            ->latest()
            ->paginate(20);

        return WorkflowResource::collection($workflows);
    }

    public function store(StoreWorkflowRequest $request): WorkflowResource
    {
        $payload = $request->validated();
        $steps = $payload['steps'] ?? [];
        unset($payload['steps']);

        $workflow = Workflow::create($payload);

        foreach ($steps as $step) {
            $workflow->steps()->create($step);
        }

        return new WorkflowResource($workflow->load('steps'));
    }

    public function show(Workflow $workflow): WorkflowResource
    {
        return new WorkflowResource($workflow->load(['steps', 'riskFindings']));
    }

    public function update(UpdateWorkflowRequest $request, Workflow $workflow): WorkflowResource
    {
        $workflow->update($request->validated());

        return new WorkflowResource($workflow->fresh(['steps', 'riskFindings']));
    }

    public function destroy(Workflow $workflow): Response
    {
        $workflow->delete();

        return response()->noContent();
    }
}
