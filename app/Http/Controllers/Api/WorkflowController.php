<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkflowRequest;
use App\Http\Requests\UpdateWorkflowRequest;
use App\Http\Resources\WorkflowResource;
use App\Models\Workflow;
use App\Services\Audit\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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

    public function store(StoreWorkflowRequest $request, AuditLogger $auditLogger): JsonResponse
    {
        $workflow = DB::transaction(function () use ($request, $auditLogger) {
            $payload = $request->validated();
            $steps = $payload['steps'] ?? [];
            unset($payload['steps']);

            $workflow = Workflow::create($payload);

            $auditLogger->created($workflow, $workflow, $request, [
                'source' => 'api',
            ]);

            foreach ($steps as $stepData) {
                $step = $workflow->steps()->create($stepData);

                $auditLogger->created($step, $workflow, $request, [
                    'source' => 'api',
                    'created_with_workflow' => true,
                ]);
            }

            return $workflow;
        });

        return (new WorkflowResource($workflow->load('steps')))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Workflow $workflow): WorkflowResource
    {
        return new WorkflowResource(
            $workflow->load(['steps', 'riskFindings'])
        );
    }

    public function update(UpdateWorkflowRequest $request, Workflow $workflow, AuditLogger $auditLogger): WorkflowResource
    {
        $oldValues = $workflow->only([
            'title',
            'description',
            'industry',
            'owner_name',
            'business_context',
        ]);

        $payload = $request->validated();
        unset($payload['steps']);

        $workflow->update($payload);

        $auditLogger->updated($workflow, $oldValues, $workflow, $request, [
            'source' => 'api',
        ]);

        return new WorkflowResource($workflow->fresh(['steps', 'riskFindings']));
    }

    public function destroy(Workflow $workflow, AuditLogger $auditLogger): Response
    {
        $auditLogger->deleted($workflow, $workflow, request(), [
            'source' => 'api',
        ]);

        $workflow->delete();

        return response()->noContent();
    }
}