@extends('layouts.app')

@section('title', 'About Project | FlowGuard AI')

@section('content')
@php
    $headerActions = '
        <a href="' . route('case-study.show') . '" class="btn btn-primary">Open Case Study</a>
        <a href="' . route('project-docs.index') . '" class="btn btn-outline-dark">Read Docs</a>
    ';
@endphp

@include('partials.page_header', [
    'title' => 'About FlowGuard AI',
    'subtitle' => 'A portfolio-grade engineering product for AI workflow risk mapping',
    'actions' => $headerActions,
])

<div class="project-hero page-card mb-4">
    <div class="project-hero-content">
        <span class="badge badge-soft mb-3">Portfolio Engineering Project</span>

        <h2 class="fw-bold mb-3">
            FlowGuard AI helps teams reason about AI automation before it reaches customers.
        </h2>

        <p class="text-muted mb-0">
            The product models AI-powered automation workflows as structured steps, evaluates each step using
            deterministic risk rules, generates scored findings, and recommends engineering controls such as
            human review, audit logging, data minimization, fallback paths, and third-party processor documentation.
        </p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">Workflows</div>
                <div class="display-6 fw-bold">{{ $workflowsCount }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">Workflow Steps</div>
                <div class="display-6 fw-bold">{{ $stepsCount }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted">Risk Findings</div>
                <div class="display-6 fw-bold">{{ $findingsCount }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card page-card h-100">
            <div class="card-body">
                <h4 class="mb-3">Problem</h4>

                <p class="text-muted">
                    Many teams adopt AI tools, customer-support automation, LLM integrations, and workflow platforms
                    before they define how data flows, where AI is used, who approves customer-facing output,
                    and how actions are logged.
                </p>

                <p class="text-muted mb-0">
                    FlowGuard AI turns this vague risk into a structured engineering workflow: map the steps,
                    classify the controls, run the rules, and produce an actionable report.
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card page-card h-100">
            <div class="card-body">
                <h4 class="mb-3">Solution</h4>

                <p class="text-muted">
                    The application evaluates workflows across privacy, human oversight, traceability,
                    third-party dependency, reliability, safety, and data governance categories.
                </p>

                <p class="text-muted mb-0">
                    Each finding includes a level, category, numeric score, control status, recommendation,
                    and engineering control, making the result explainable and auditable.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="card page-card mb-4">
    <div class="card-body">
        <h4 class="mb-3">Architecture Summary</h4>

        <div class="architecture-grid">
            <div class="architecture-box">
                <div class="fw-semibold mb-1">Presentation Layer</div>
                <div class="small text-muted">
                    Blade views, reusable partials, separated CSS/JS, dashboard, reports, data flow view, case study pages.
                </div>
            </div>

            <div class="architecture-box">
                <div class="fw-semibold mb-1">Controller Layer</div>
                <div class="small text-muted">
                    Thin web and API controllers that coordinate requests, validation, service calls, and responses.
                </div>
            </div>

            <div class="architecture-box">
                <div class="fw-semibold mb-1">Domain Layer</div>
                <div class="small text-muted">
                    Rule registry, deterministic risk rules, DTOs, risk categories, control statuses, and scoring logic.
                </div>
            </div>

            <div class="architecture-box">
                <div class="fw-semibold mb-1">Persistence Layer</div>
                <div class="small text-muted">
                    Eloquent models for workflows, workflow steps, risk findings, and analysis reports.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="card page-card h-100">
            <div class="card-body">
                <h5 class="mb-3">Backend Engineering</h5>
                <ul class="compact-list text-muted">
                    <li>Laravel MVC structure</li>
                    <li>Service layer for risk analysis</li>
                    <li>Domain rules and DTOs</li>
                    <li>API resources and Form Requests</li>
                    <li>MySQL-ready migrations</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card page-card h-100">
            <div class="card-body">
                <h5 class="mb-3">AI Workflow Design</h5>
                <ul class="compact-list text-muted">
                    <li>Human-in-the-loop detection</li>
                    <li>Customer-facing AI control checks</li>
                    <li>Prompt/data minimization reasoning</li>
                    <li>Fallback and reliability controls</li>
                    <li>Third-party API risk mapping</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card page-card h-100">
            <div class="card-body">
                <h5 class="mb-3">Portfolio Value</h5>
                <ul class="compact-list text-muted">
                    <li>Clear product story</li>
                    <li>Case study demo scenario</li>
                    <li>Report and data-flow views</li>
                    <li>Explainable risk methodology</li>
                    <li>CV-ready engineering narrative</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card page-card">
    <div class="card-body">
        <h4 class="mb-3">CV Positioning</h4>

        <div class="cv-snippet">
            <p class="mb-0">
                <strong>FlowGuard AI — AI Workflow Risk Mapping Platform</strong><br>
                Designed and built a Laravel-based platform that models AI-powered automation workflows,
                applies deterministic risk rules, scores findings across privacy, oversight, traceability,
                third-party, reliability, and safety categories, and generates structured reports with
                engineering controls such as human review, audit logging, fallback paths, and data minimization.
            </p>
        </div>
    </div>
</div>
@endsection