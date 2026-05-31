@extends('layouts.app')

@section('title', 'Data Flow | FlowGuard AI')

@section('content')
@php
    $headerActions = '
        <a href="' . route('workflows.show', $workflow) . '" class="btn btn-outline-secondary">Back to Workflow</a>
        <button onclick="window.print()" class="btn btn-primary">Print / Save PDF</button>
    ';
@endphp

@include('partials.page_header', [
    'title' => 'Data Flow View',
    'subtitle' => $workflow->title,
    'actions' => $headerActions,
])

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">AI Steps</div>
                <div class="display-6 fw-bold">{{ $summary['ai_steps_count'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">Personal Data Steps</div>
                <div class="display-6 fw-bold">{{ $summary['personal_data_steps_count'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">External API Steps</div>
                <div class="display-6 fw-bold">{{ $summary['external_api_steps_count'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">Human Review Steps</div>
                <div class="display-6 fw-bold">{{ $summary['human_review_steps_count'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card page-card">
            <div class="card-body">
                <h4 class="mb-4">Workflow Data Flow</h4>

                @if ($workflow->steps->isEmpty())
                    <div class="text-muted">No workflow steps available.</div>
                @else
                    <div class="data-flow-timeline">
                        @foreach ($workflow->steps as $step)
                            <div class="data-flow-step">
                                <div class="data-flow-node"></div>

                                <div class="data-flow-box">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="fw-semibold">
                                                {{ $step->step_order }}. {{ $step->name }}
                                            </div>
                                            <div class="text-muted small">{{ $step->step_type }}</div>
                                        </div>

                                        <div>
                                            @include('partials.step_flags', ['step' => $step])
                                        </div>
                                    </div>

                                    @if ($step->description)
                                        <p class="small text-muted mt-3 mb-3">
                                            {{ $step->description }}
                                        </p>
                                    @endif

                                    <div class="row g-3 mt-1">
                                        <div class="col-md-4">
                                            <div class="text-muted small">Input Data</div>
                                            @if ($step->input_data)
                                                <ul class="compact-list small">
                                                    @foreach ($step->input_data as $item)
                                                        <li>{{ $item }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="small">-</div>
                                            @endif
                                        </div>

                                        <div class="col-md-4">
                                            <div class="text-muted small">Output Data</div>
                                            @if ($step->output_data)
                                                <ul class="compact-list small">
                                                    @foreach ($step->output_data as $item)
                                                        <li>{{ $item }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="small">-</div>
                                            @endif
                                        </div>

                                        <div class="col-md-4">
                                            <div class="text-muted small">Systems</div>
                                            @if ($step->systems_involved)
                                                <ul class="compact-list small">
                                                    @foreach ($step->systems_involved as $item)
                                                        <li>{{ $item }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="small">-</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card page-card mb-4">
            <div class="card-body">
                <h4 class="mb-3">Data Inventory</h4>

                <div class="mb-3">
                    <div class="text-muted small">Input Data Categories</div>
                    @if ($dataCategories->isEmpty())
                        <div>-</div>
                    @else
                        <div class="flag-list mt-2">
                            @foreach ($dataCategories as $item)
                                <span class="badge badge-soft">{{ $item }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Output Data Categories</div>
                    @if ($outputCategories->isEmpty())
                        <div>-</div>
                    @else
                        <div class="flag-list mt-2">
                            @foreach ($outputCategories as $item)
                                <span class="badge badge-soft">{{ $item }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    <div class="text-muted small">Systems Involved</div>
                    @if ($systems->isEmpty())
                        <div>-</div>
                    @else
                        <div class="flag-list mt-2">
                            @foreach ($systems as $item)
                                <span class="badge text-bg-light">{{ $item }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card page-card">
            <div class="card-body">
                <h4 class="mb-3">Engineering Notes</h4>

                <ul class="compact-list">
                    <li>AI steps should minimize personal data before model calls.</li>
                    <li>External API steps should be documented as third-party processors.</li>
                    <li>Customer-facing steps should have disclosure and escalation paths.</li>
                    <li>High-risk or irreversible actions should include human approval.</li>
                    <li>Audit logs should capture inputs, outputs, approvals, and timestamps.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection