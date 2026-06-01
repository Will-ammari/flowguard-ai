<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Workflow;
use App\Services\Audit\AuditLogger;
use Illuminate\Http\Request;

class WorkflowWebController extends Controller
{
    public function index()
    {
        $workflows = Workflow::withCount(['steps', 'riskFindings'])
            ->latest()
            ->paginate(10);

        return view('workflows.index', [
            'workflows' => $workflows,
        ]);
    }

    public function create()
    {
        return view('workflows.create');
    }

    public function store(Request $request, AuditLogger $auditLogger)
    {
        $validated = $this->validateWorkflow($request);

        $workflow = Workflow::create($validated);

        $auditLogger->created($workflow, $workflow, $request, [
            'source' => 'web',
        ]);

        return redirect()
            ->route('workflows.show', $workflow)
            ->with('success', 'Workflow created successfully. Now add workflow steps.');
    }

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

        return view('workflows.show', [
            'workflow' => $workflow,
            'latestReport' => $latestReport,
        ]);
    }

    public function edit(Workflow $workflow)
    {
        return view('workflows.edit', [
            'workflow' => $workflow,
        ]);
    }

    public function update(Request $request, Workflow $workflow, AuditLogger $auditLogger)
    {
        $validated = $this->validateWorkflow($request);

        $oldValues = $workflow->only([
            'title',
            'industry',
            'owner_name',
            'description',
            'business_context',
        ]);

        $workflow->update($validated);

        $auditLogger->updated($workflow, $oldValues, $workflow, $request, [
            'source' => 'web',
        ]);

        return redirect()
            ->route('workflows.show', $workflow)
            ->with('success', 'Workflow updated successfully.');
    }

    public function destroy(Request $request, Workflow $workflow, AuditLogger $auditLogger)
    {
        $auditLogger->deleted($workflow, $workflow, $request, [
            'source' => 'web',
        ]);

        $workflow->delete();

        return redirect()
            ->route('workflows.index')
            ->with('success', 'Workflow deleted successfully.');
    }

    private function validateWorkflow(Request $request)
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'business_context' => ['nullable', 'string'],
        ]);
    }
}