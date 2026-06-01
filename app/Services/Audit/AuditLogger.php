<?php

namespace App\Services\Audit;

use App\Models\AuditLog;
use App\Models\Workflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public function created(Model $entity, Workflow $workflow = null, Request $request = null, array $metadata = []): AuditLog
    {
        return $this->record(
            'created',
            $entity,
            $workflow,
            [],
            $entity->getAttributes(),
            $request,
            $metadata
        );
    }

    public function updated(Model $entity, array $oldValues, Workflow $workflow = null, Request $request = null, array $metadata = []): AuditLog
    {
        return $this->record(
            'updated',
            $entity,
            $workflow,
            $oldValues,
            $entity->getChanges(),
            $request,
            $metadata
        );
    }

    public function deleted(Model $entity, Workflow $workflow = null, Request $request = null, array $metadata = []): AuditLog
    {
        return $this->record(
            'deleted',
            $entity,
            $workflow,
            $entity->getAttributes(),
            [],
            $request,
            $metadata
        );
    }

    public function workflowAnalyzed(Workflow $workflow, Request $request = null, array $metadata = []): AuditLog
    {
        return $this->record(
            'workflow_analyzed',
            $workflow,
            $workflow,
            [],
            [],
            $request,
            $metadata
        );
    }

    public function record(
        string $action,
        Model $entity = null,
        Workflow $workflow = null,
        array $oldValues = [],
        array $newValues = [],
        Request $request = null,
        array $metadata = []
    ): AuditLog {
        return AuditLog::create([
            'user_id' => Auth::id(),
            'workflow_id' => $workflow ? $workflow->id : $this->resolveWorkflowId($entity),
            'action' => $action,
            'entity_type' => $entity ? get_class($entity) : null,
            'entity_id' => $entity ? $entity->getKey() : null,
            'old_values' => $oldValues ?: null,
            'new_values' => $newValues ?: null,
            'metadata' => $metadata ?: null,
            'ip_address' => $request ? $request->ip() : null,
            'user_agent' => $request ? $request->userAgent() : null,
        ]);
    }

    private function resolveWorkflowId(Model $entity = null): ?int
    {
        if (!$entity) {
            return null;
        }

        if ($entity instanceof Workflow) {
            return $entity->id;
        }

        if (isset($entity->workflow_id)) {
            return $entity->workflow_id;
        }

        return null;
    }
}