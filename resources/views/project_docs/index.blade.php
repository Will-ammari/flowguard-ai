@extends('layouts.app')

@section('title', 'Project Documentation | FlowGuard AI')

@section('content')
@php
    $headerActions = '
        <a href="' . route('about-project.show') . '" class="btn btn-outline-dark">About Project</a>
        <a href="' . route('case-study.show') . '" class="btn btn-primary">Case Study</a>
    ';
@endphp

@include('partials.page_header', [
    'title' => 'Project Documentation',
    'subtitle' => 'Architecture, methodology, demo flow, and engineering decisions',
    'actions' => $headerActions,
])

<div class="row g-4">
    <div class="col-lg-4">
        <div class="sticky-doc-nav page-card">
            <div class="card-body">
                <h5 class="mb-3">Contents</h5>

                <ul class="doc-nav-list">
                    <li><a href="#product-summary">Product Summary</a></li>
                    <li><a href="#architecture">Architecture</a></li>
                    <li><a href="#risk-methodology">Risk Methodology</a></li>
                    <li><a href="#data-model">Data Model</a></li>
                    <li><a href="#demo-scenario">Demo Scenario</a></li>
                    <li><a href="#engineering-decisions">Engineering Decisions</a></li>
                    <li><a href="#limitations">Limitations</a></li>
                    <li><a href="#future-work">Future Work</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div id="product-summary" class="card page-card mb-4">
            <div class="card-body">
                <h3 class="mb-3">Product Summary</h3>

                <p class="text-muted">
                    FlowGuard AI is an engineering MVP that helps teams map and analyze AI-powered automation workflows.
                    It is designed for workflows involving LLMs, webhooks, third-party APIs, customer communication,
                    data storage, and human approval processes.
                </p>

                <p class="text-muted mb-0">
                    The product is intentionally explainable: risk decisions come from deterministic rules, not from
                    opaque AI judgment. This makes findings predictable, testable, and auditable.
                </p>
            </div>
        </div>

        <div id="architecture" class="card page-card mb-4">
            <div class="card-body">
                <h3 class="mb-3">Architecture</h3>

                <pre class="architecture-diagram">User / Browser
      |
      v
Blade Views + Bootstrap + App CSS/JS
      |
      v
Web Controllers / API Controllers
      |
      v
Form Requests + Services
      |
      v
RiskAnalyzer Service
      |
      v
Risk Rule Registry
      |
      v
Domain Risk Rules
      |
      v
Eloquent Models
      |
      v
MySQL Database</pre>

                <p class="text-muted mb-0">
                    Controllers remain thin. The domain-specific logic lives inside the service and rule layers.
                    Views are separated into reusable partials for badges, alerts, page headers, and step flags.
                </p>
            </div>
        </div>

        <div id="risk-methodology" class="card page-card mb-4">
            <div class="card-body">
                <h3 class="mb-3">Risk Methodology</h3>

                <p class="text-muted">
                    The system evaluates workflow steps using engineering flags:
                </p>

                <div class="flag-list mb-3">
                    <span class="badge badge-soft">Uses AI</span>
                    <span class="badge badge-soft">Uses Personal Data</span>
                    <span class="badge badge-soft">Customer-facing</span>
                    <span class="badge badge-soft">Human Review</span>
                    <span class="badge badge-soft">Audit Log</span>
                    <span class="badge badge-soft">Fallback Path</span>
                    <span class="badge badge-soft">External API</span>
                    <span class="badge badge-soft">Sensitive Data</span>
                    <span class="badge badge-soft">Irreversible Action</span>
                </div>

                <p class="text-muted">
                    Each rule can create a finding with:
                </p>

                <ul class="compact-list text-muted">
                    <li>Risk code and title</li>
                    <li>Risk level: Low, Medium, High, Critical</li>
                    <li>Risk category: privacy, oversight, traceability, third-party, reliability, safety, governance</li>
                    <li>Risk score from 1 to 10</li>
                    <li>Control status: Missing, Partial, Present, or Not Applicable</li>
                    <li>Recommendation and engineering control</li>
                </ul>
            </div>
        </div>

        <div id="data-model" class="card page-card mb-4">
            <div class="card-body">
                <h3 class="mb-3">Data Model</h3>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th>Model</th>
                            <th>Purpose</th>
                            <th>Important Fields</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="fw-semibold">Workflow</td>
                            <td>Represents an AI or automation process.</td>
                            <td>title, industry, owner, description, business context</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">WorkflowStep</td>
                            <td>Represents one ordered step in a workflow.</td>
                            <td>step type, inputs, outputs, systems, engineering flags</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">RiskFinding</td>
                            <td>Represents one detected risk.</td>
                            <td>level, category, score, control status, recommendation</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">AnalysisReport</td>
                            <td>Stores a report snapshot after analysis.</td>
                            <td>overall risk, summary, report payload</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="demo-scenario" class="card page-card mb-4">
            <div class="card-body">
                <h3 class="mb-3">Demo Scenario</h3>

                <p class="text-muted">
                    The portfolio case study compares two workflows:
                </p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="category-card h-100">
                            <h6 class="fw-bold">Baseline Workflow</h6>
                            <p class="small text-muted mb-0">
                                AI receives customer messages and sends responses directly without human review,
                                audit logging, fallback handling, or data minimization.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="category-card h-100">
                            <h6 class="fw-bold">Improved Workflow</h6>
                            <p class="small text-muted mb-0">
                                The workflow adds data minimization, internal AI suggestions, human approval,
                                audit logs, fallback paths, and controlled customer communication.
                            </p>
                        </div>
                    </div>
                </div>

                <p class="text-muted mt-3 mb-0">
                    The expected result is a reduction in risk level, finding count, maximum risk score, and missing controls.
                </p>
            </div>
        </div>

        <div id="engineering-decisions" class="card page-card mb-4">
            <div class="card-body">
                <h3 class="mb-3">Engineering Decisions</h3>

                <ul class="compact-list text-muted">
                    <li><strong>Deterministic rules over LLM judgment:</strong> risk decisions must be explainable.</li>
                    <li><strong>Service layer:</strong> risk analysis is not placed inside controllers.</li>
                    <li><strong>Domain rules:</strong> each risk condition is isolated and testable.</li>
                    <li><strong>Persisted findings:</strong> reports can be reviewed later and compared over time.</li>
                    <li><strong>Blade partials:</strong> UI elements are reusable and cleaner to maintain.</li>
                    <li><strong>Separate CSS/JS:</strong> presentation behavior is not buried inside Blade templates.</li>
                </ul>
            </div>
        </div>

        <div id="limitations" class="card page-card mb-4">
            <div class="card-body">
                <h3 class="mb-3">Limitations</h3>

                <ul class="compact-list text-muted">
                    <li>The tool does not provide legal advice.</li>
                    <li>The risk rules are simplified for MVP purposes.</li>
                    <li>The workflow model depends on user-provided step flags.</li>
                    <li>The current system does not automatically inspect real n8n workflows.</li>
                    <li>PDF export currently uses browser print instead of server-side rendering.</li>
                </ul>
            </div>
        </div>

        <div id="future-work" class="card page-card">
            <div class="card-body">
                <h3 class="mb-3">Future Work</h3>

                <ul class="compact-list text-muted">
                    <li>Import workflows from n8n JSON exports.</li>
                    <li>Add server-side PDF report generation.</li>
                    <li>Add authentication and team workspaces.</li>
                    <li>Add workflow versioning and comparison history.</li>
                    <li>Add LLM-generated executive summaries while keeping rule-based decisions as source of truth.</li>
                    <li>Add more automated tests for every risk rule.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection