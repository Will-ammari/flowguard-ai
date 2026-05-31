@extends('layouts.app')

@section('title', 'Analysis Report | FlowGuard AI')

@section('content')
@php
    $headerActions = '
        <a href="' . route('workflows.show', $workflow) . '" class="btn btn-outline-secondary">Back to Workflow</a>
        <a href="' . route('workflows.data-flow', $workflow) . '" class="btn btn-outline-dark">Data Flow</a>
        <button onclick="window.print()" class="btn btn-primary">Print / Save PDF</button>
    ';
@endphp

@include('partials.page_header', [
    'title' => 'Analysis Report',
    'subtitle' => $workflow->title . ' · Generated ' . $latestReport->created_at->format('Y-m-d H:i'),
    'actions' => $headerActions,
])

<div class="card page-card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <h4 class="mb-2">Executive Summary</h4>
                <p class="mb-0 text-muted">{{ $latestReport->summary }}</p>
            </div>

            @include('partials.risk_badge', [
                'level' => $latestReport->overall_risk_level,
                'class' => 'px-3 py-2',
            ])
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">Workflow Steps</div>
                <div class="display-6 fw-bold">{{ $workflow->steps->count() }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">Findings</div>
                <div class="display-6 fw-bold">{{ $workflow->riskFindings->count() }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">Max Score</div>
                <div class="display-6 fw-bold">{{ $maxRiskScore }}/10</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">Average Score</div>
                <div class="display-6 fw-bold">{{ $averageRiskScore }}/10</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card page-card h-100">
            <div class="card-body">
                <h4 class="mb-3">Risk Category Breakdown</h4>

                @if ($findingsByCategory->isEmpty())
                    <div class="text-muted">No categories detected.</div>
                @else
                    <div class="row g-3">
                        @foreach ($findingsByCategory as $category => $count)
                            <div class="col-md-6">
                                <div class="category-card">
                                    <div class="text-muted small">{{ $category }}</div>
                                    <div class="h3 mb-0">{{ $count }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card page-card h-100">
            <div class="card-body">
                <h4 class="mb-3">Control Status</h4>

                @if ($findingsByControlStatus->isEmpty())
                    <div class="text-muted">No controls detected.</div>
                @else
                    <table class="table align-middle mb-0">
                        <tbody>
                        @foreach ($findingsByControlStatus as $status => $count)
                            <tr>
                                <td>@include('partials.control_status_badge', ['status' => $status])</td>
                                <td class="text-end fw-semibold">{{ $count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card page-card mb-4">
    <div class="card-body">
        <h4 class="mb-3">Workflow Metadata</h4>

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="text-muted small">Title</div>
                <div class="fw-semibold">{{ $workflow->title }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="text-muted small">Industry</div>
                <div>{{ $workflow->industry ?: '-' }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="text-muted small">Owner / Team</div>
                <div>{{ $workflow->owner_name ?: '-' }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="text-muted small">Report Date</div>
                <div>{{ $latestReport->created_at->format('Y-m-d H:i') }}</div>
            </div>
        </div>

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

<div class="card page-card mb-4">
    <div class="card-body">
        <h4 class="mb-3">Workflow Steps</h4>

        @if ($workflow->steps->isEmpty())
            <div class="text-muted">No steps were defined.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Step</th>
                        <th>Type</th>
                        <th>Systems</th>
                        <th>Flags</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($workflow->steps as $step)
                        <tr>
                            <td>{{ $step->step_order }}</td>
                            <td>
                                <div class="fw-semibold">{{ $step->name }}</div>
                                <div class="small text-muted">{{ $step->description }}</div>
                            </td>
                            <td>{{ $step->step_type }}</td>
                            <td>
                                @if ($step->systems_involved)
                                    {{ implode(', ', $step->systems_involved) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @include('partials.step_flags', ['step' => $step])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<div class="card page-card mb-4">
    <div class="card-body">
        <h4 class="mb-3">Risk Findings and Controls</h4>

        @if ($workflow->riskFindings->isEmpty())
            <div class="text-muted">No findings were generated.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Score</th>
                        <th>Level</th>
                        <th>Category</th>
                        <th>Risk</th>
                        <th>Control Status</th>
                        <th>Affected Step</th>
                        <th>Recommended Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($workflow->riskFindings as $finding)
                        <tr>
                            <td><span class="score-pill">{{ $finding->risk_score }}</span></td>
                            <td>@include('partials.risk_badge', ['level' => $finding->risk_level])</td>
                            <td>{{ $finding->risk_category }}</td>
                            <td>
                                <div class="fw-semibold">{{ $finding->risk_title }}</div>
                                <div class="small text-muted mt-1">{{ $finding->description }}</div>
                                <div class="small mt-2">
                                    <strong>Recommendation:</strong>
                                    {{ $finding->recommendation }}
                                </div>
                            </td>
                            <td>@include('partials.control_status_badge', ['status' => $finding->control_status])</td>
                            <td>
                                @if ($finding->workflowStep)
                                    {{ $finding->workflowStep->name }}
                                @else
                                    Workflow-level
                                @endif
                            </td>
                            <td>{{ $finding->engineering_control ?: '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<div class="card page-card">
    <div class="card-body">
        <h4 class="mb-3">Engineering Improvement Plan</h4>

        <ol class="mb-0">
            <li>Prioritize missing controls with risk scores of 8 or higher.</li>
            <li>Minimize or redact personal data before any AI processing step.</li>
            <li>Add human approval before customer-facing or irreversible actions.</li>
            <li>Maintain audit logs for inputs, outputs, approvals, providers, and timestamps.</li>
            <li>Document third-party processors and the categories of data shared with them.</li>
            <li>Add fallback paths for AI timeout, failure, or low-confidence output.</li>
        </ol>
    </div>
</div>
@endsection
