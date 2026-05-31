@extends('layouts.app')

@section('title', $workflow->title . ' | FlowGuard AI')

@section('content')
@php
    $headerActions = '
        <a href="' . route('workflows.edit', $workflow) . '" class="btn btn-outline-secondary">Edit Workflow</a>
        <a href="' . route('workflow-steps.create', $workflow) . '" class="btn btn-outline-primary">Add Step</a>
        <a href="' . route('workflows.data-flow', $workflow) . '" class="btn btn-outline-dark">Data Flow</a>
    ';

    if ($latestReport) {
        $headerActions .= '<a href="' . route('workflows.report', $workflow) . '" class="btn btn-outline-dark">View Report</a>';
    }

    $headerActions .= '
        <form method="POST" action="' . route('workflows.analyze', $workflow) . '">
            ' . csrf_field() . '
            <button type="submit" class="btn btn-primary">Run Analysis</button>
        </form>
    ';
@endphp

@include('partials.page_header', [
    'title' => $workflow->title,
    'subtitle' => ($workflow->industry ?: 'No industry specified') . ($workflow->owner_name ? ' · ' . $workflow->owner_name : ''),
    'actions' => $headerActions,
])

@if ($latestReport)
    <div class="card page-card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <h5 class="mb-1">Latest Analysis Report</h5>
                    <p class="text-muted mb-0">{{ $latestReport->summary }}</p>
                </div>

                @include('partials.risk_badge', [
                    'level' => $latestReport->overall_risk_level,
                    'class' => 'px-3 py-2',
                ])
            </div>
        </div>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card page-card mb-4">
            <div class="card-body">
                <h4 class="mb-3">Workflow Overview</h4>

                <div class="mb-3">
                    <div class="text-muted small">Description</div>
                    <div>{{ $workflow->description ?: 'No description provided.' }}</div>
                </div>

                <div>
                    <div class="text-muted small">Business Context</div>
                    <div>{{ $workflow->business_context ?: 'No business context provided.' }}</div>
                </div>
            </div>
        </div>

        <div class="card page-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Workflow Steps</h4>
                    <a href="{{ route('workflow-steps.create', $workflow) }}" class="btn btn-sm btn-outline-primary">
                        Add Step
                    </a>
                </div>

                @if ($workflow->steps->isEmpty())
                    <div class="text-muted">
                        No steps yet. Add the first workflow step.
                    </div>
                @else
                    <div>
                        @foreach ($workflow->steps as $step)
                            <div class="workflow-step-card">
                                <div class="d-flex justify-content-between gap-3">
                                    <div>
                                        <div class="fw-semibold">
                                            {{ $step->step_order }}. {{ $step->name }}
                                        </div>
                                        <div class="text-muted small">{{ $step->step_type }}</div>
                                    </div>

                                    <div class="text-end">
                                        @if ($step->uses_ai)
                                            <span class="badge bg-primary mb-2">AI</span>
                                        @endif

                                        <div>
                                            <a
                                                href="{{ route('workflow-steps.edit', [$workflow, $step]) }}"
                                                class="btn btn-sm btn-outline-secondary"
                                            >
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                @if ($step->description)
                                    <div class="mt-2 small">{{ $step->description }}</div>
                                @endif

                                <div class="mt-2">
                                    @include('partials.step_flags', ['step' => $step])
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card page-card">
            <div class="card-body">
                <h4 class="mb-3">Risk Findings</h4>

                @if ($workflow->riskFindings->isEmpty())
                    <div class="text-muted">
                        No risk findings yet. Run analysis after adding workflow steps.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th>Score</th>
                                <th>Level</th>
                                <th>Category</th>
                                <th>Finding</th>
                                <th>Step</th>
                                <th>Control Status</th>
                                <th>Engineering Control</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($workflow->riskFindings as $finding)
                                <tr>
                                    <td><span class="score-pill">{{ $finding->risk_score }}</span></td>
                                    <td>
                                        @include('partials.risk_badge', ['level' => $finding->risk_level])
                                    </td>
                                    <td>{{ $finding->risk_category }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $finding->risk_title }}</div>
                                        <div class="small text-muted mt-1">{{ $finding->description }}</div>
                                        <div class="small mt-2">
                                            <strong>Recommendation:</strong>
                                            {{ $finding->recommendation }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($finding->workflowStep)
                                            {{ $finding->workflowStep->name }}
                                        @else
                                            <span class="text-muted">Workflow-level</span>
                                        @endif
                                    </td>
                                    <td>
                                        @include('partials.control_status_badge', ['status' => $finding->control_status])
                                    </td>
                                    <td>
                                        {{ $finding->engineering_control ?: '-' }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('workflows.report', $workflow) }}" class="btn btn-outline-dark">
                        Open Full Report
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection