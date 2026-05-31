@extends('layouts.app')

@section('title', 'Workflows | FlowGuard AI')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-1">Workflows</h1>
        <p class="text-muted mb-0">Manage AI-powered automation workflows and risk analysis results.</p>
    </div>

    <a href="{{ route('workflows.create') }}" class="btn btn-primary">
        New Workflow
    </a>
</div>

<div class="card page-card">
    <div class="card-body">
        @if ($workflows->isEmpty())
            <div class="text-muted">
                No workflows found. Create your first workflow.
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Industry</th>
                        <th>Owner</th>
                        <th>Steps</th>
                        <th>Findings</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($workflows as $workflow)
                        <tr>
                            <td class="fw-semibold">{{ $workflow->title }}</td>
                            <td>{{ $workflow->industry ?: '-' }}</td>
                            <td>{{ $workflow->owner_name ?: '-' }}</td>
                            <td>
                                <span class="badge badge-soft">{{ $workflow->steps_count }}</span>
                            </td>
                            <td>
                                <span class="badge badge-soft">{{ $workflow->risk_findings_count }}</span>
                            </td>
                            <td>{{ $workflow->created_at->format('Y-m-d') }}</td>
                            <td class="text-end">
                                <a href="{{ route('workflows.show', $workflow) }}" class="btn btn-sm btn-primary">
                                    Open
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{ $workflows->links() }}
        @endif
    </div>
</div>
@endsection