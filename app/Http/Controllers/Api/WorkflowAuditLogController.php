<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogResource;
use App\Models\Workflow;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WorkflowAuditLogController extends Controller
{
    public function index(Workflow $workflow): AnonymousResourceCollection
    {
        $auditLogs = $workflow->auditLogs()
            ->latest()
            ->paginate(25);

        return AuditLogResource::collection($auditLogs);
    }
}