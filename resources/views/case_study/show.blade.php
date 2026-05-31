@extends('layouts.app')

@section('title', 'Case Study | FlowGuard AI')

@section('content')
@php
    $headerActions = '
        <form method="POST" action="' . route('demo-workflows.rebuild') . '" data-confirm="Rebuild demo workflows and analysis results?">
            ' . csrf_field() . '
            <button type="submit" class="btn btn-primary">Build Demo Case Study</button>
        </form>
        <button onclick="window.print()" class="btn btn-outline-dark">Print / Save PDF</button>
    ';
@endphp

@include('partials.page_header', [
    'title' => 'Portfolio Case Study',
    'subtitle' => 'AI-assisted WhatsApp support workflow: baseline risk vs controlled engineering design',
    'actions' => $headerActions,
])

<div class="case-hero page-card mb-4">
    <div class="case-hero-content">
        <span class="badge badge-soft mb-3">Engineering Demo Scenario</span>
        <h2 class="fw-bold mb-3">From risky AI automation to controlled human-in-the-loop workflow</h2>
        <p class="mb-0 text-muted">
            This case study demonstrates how FlowGuard AI maps an automation workflow, identifies risk points,
            scores findings, and recommends controls such as data minimization, human review, audit logging,
            fallback paths, and third-party processor documentation.
        </p>
    </div>
</div>

@if (!$hasDemoData)
    <div class="card page-card">
        <div class="card-body">
            <h4 class="mb-2">No demo case study data yet</h4>
            <p class="text-muted mb-3">
                Click <strong>Build Demo Case Study</strong> to create two workflows: an uncontrolled baseline and an improved controlled version.
            </p>

            <form method="POST" action="{{ route('demo-workflows.rebuild') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Build Demo Case Study</button>
            </form>
        </div>
    </div>
@else
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="text-muted">Baseline Risk</div>
                    <div class="h3 fw-bold mb-0">{{ $comparison['before_risk'] }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="text-muted">Improved Risk</div>
                    <div class="h3 fw-bold mb-0">{{ $comparison['after_risk'] }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="text-muted">Finding Change</div>
                    <div class="h3 fw-bold mb-0">
                        {{ $comparison['before_findings'] }} → {{ $comparison['after_findings'] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="text-muted">Max Score Change</div>
                    <div class="h3 fw-bold mb-0">
                        {{ $comparison['before_max_score'] }}/10 → {{ $comparison['after_max_score'] }}/10
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card page-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4 class="mb-1">Baseline Workflow</h4>
                            <div class="text-muted small">Uncontrolled direct AI automation</div>
                        </div>

                        @include('partials.risk_badge', [
                            'level' => $comparison['before_risk'],
                            'class' => 'px-3 py-2',
                        ])
                    </div>

                    <p class="text-muted">
                        The baseline workflow sends personal customer messages to an LLM and sends generated replies directly to customers.
                        It intentionally lacks human review, audit logging, fallback behavior, and data minimization.
                    </p>

                    <div class="mb-3">
                        <div class="text-muted small">Key Problems</div>
                        <ul class="compact-list mt-2">
                            <li>Customer-facing AI output without approval.</li>
                            <li>Personal data is sent to external AI services.</li>
                            <li>No audit trail for prompt, output, approval, or final action.</li>
                            <li>No fallback path for timeout, failure, or low confidence.</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('workflows.show', $before) }}" class="btn btn-outline-primary">Open Workflow</a>
                        <a href="{{ route('workflows.report', $before) }}" class="btn btn-outline-dark">Open Report</a>
                        <a href="{{ route('workflows.data-flow', $before) }}" class="btn btn-outline-secondary">Data Flow</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card page-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4 class="mb-1">Improved Workflow</h4>
                            <div class="text-muted small">Controlled human-in-the-loop design</div>
                        </div>

                        @include('partials.risk_badge', [
                            'level' => $comparison['after_risk'],
                            'class' => 'px-3 py-2',
                        ])
                    </div>

                    <p class="text-muted">
                        The improved workflow keeps AI assistance but adds engineering controls before the customer-facing action.
                        It shows how design choices can reduce operational and governance risk.
                    </p>

                    <div class="mb-3">
                        <div class="text-muted small">Added Controls</div>
                        <ul class="compact-list mt-2">
                            <li>Data minimization before LLM processing.</li>
                            <li>Human approval queue before sending replies.</li>
                            <li>Audit logs for workflow events and approvals.</li>
                            <li>Fallback path for AI failure or low-confidence output.</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('workflows.show', $after) }}" class="btn btn-outline-primary">Open Workflow</a>
                        <a href="{{ route('workflows.report', $after) }}" class="btn btn-outline-dark">Open Report</a>
                        <a href="{{ route('workflows.data-flow', $after) }}" class="btn btn-outline-secondary">Data Flow</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card page-card mb-4">
        <div class="card-body">
            <h4 class="mb-3">Engineering Narrative</h4>

            <div class="case-timeline">
                <div class="case-timeline-item">
                    <h6 class="fw-bold">1. Model the workflow</h6>
                    <p class="text-muted mb-0">
                        The workflow is decomposed into ordered steps with systems, input data, output data, and engineering flags.
                    </p>
                </div>

                <div class="case-timeline-item">
                    <h6 class="fw-bold">2. Run deterministic risk rules</h6>
                    <p class="text-muted mb-0">
                        The risk engine evaluates transparent rules for privacy, oversight, traceability, third-party dependencies, reliability, and safety.
                    </p>
                </div>

                <div class="case-timeline-item">
                    <h6 class="fw-bold">3. Score and categorize findings</h6>
                    <p class="text-muted mb-0">
                        Each finding receives a risk level, category, 1-10 score, control status, recommendation, and engineering control.
                    </p>
                </div>

                <div class="case-timeline-item">
                    <h6 class="fw-bold">4. Improve the design</h6>
                    <p class="text-muted mb-0">
                        The improved workflow demonstrates concrete controls: minimization, approval queue, logging, fallback, and processor documentation.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card page-card">
        <div class="card-body">
            <h4 class="mb-3">Portfolio Summary</h4>
            <p class="text-muted mb-3">
                This project demonstrates backend engineering, MVC architecture, service-layer design, workflow modeling,
                deterministic rule engines, risk scoring, report generation, and human-in-the-loop AI system design.
            </p>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="category-card h-100">
                        <div class="fw-semibold mb-1">Architecture</div>
                        <div class="small text-muted">
                            Laravel MVC, service layer, domain rules, reusable Blade partials, separated CSS/JS.
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="category-card h-100">
                        <div class="fw-semibold mb-1">Risk Engine</div>
                        <div class="small text-muted">
                            Rule registry, deterministic analysis, scoring, categories, control status, reports.
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="category-card h-100">
                        <div class="fw-semibold mb-1">Product Value</div>
                        <div class="small text-muted">
                            Helps teams reason about AI workflows before deploying automation to customers.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection