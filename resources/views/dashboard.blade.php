@extends('layouts.app')

@section('title', 'Dashboard | FlowGuard AI')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h1 class="fw-bold mb-2">AI Workflow Risk Mapping</h1>
        <p class="text-muted mb-0">
            Build workflows, classify automation steps, run rule-based risk analysis, and generate engineering-grade findings.
        </p>
    </div>

    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('workflows.create') }}" class="btn btn-primary">
            Create Workflow
        </a>
    </div>
</div>

<div class="card page-card mb-4">
    <div class="card-body">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <span class="badge badge-soft mb-2">Portfolio Demo</span>
                <h4 class="mb-2">Build the AI workflow case study</h4>
                <p class="text-muted mb-0">
                    Generate a baseline risky workflow and an improved controlled workflow, then compare their risk levels,
                    findings, data flow, and recommended engineering controls.
                </p>
            </div>

            <div class="col-lg-4 text-lg-end">
                <div class="d-flex gap-2 justify-content-lg-end flex-wrap">
                    <a href="{{ route('case-study.show') }}" class="btn btn-outline-dark">
                        Open Case Study
                    </a>

                    <form method="POST" action="{{ route('demo-workflows.rebuild') }}" data-confirm="Rebuild demo workflows and analysis results?">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Build Demo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
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
                <span class="badge badge-soft mb-2">Project Story</span>
                <h4 class="mb-2">About the engineering product</h4>
                <p class="text-muted">
                    Understand the product problem, architecture, engineering scope, and CV positioning.
                </p>
                <a href="{{ route('about-project.show') }}" class="btn btn-outline-primary">
                    Open About Project
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card page-card h-100">
            <div class="card-body">
                <span class="badge badge-soft mb-2">Technical Docs</span>
                <h4 class="mb-2">Read architecture and methodology</h4>
                <p class="text-muted">
                    Review the risk methodology, data model, engineering decisions, limitations, and future work.
                </p>
                <a href="{{ route('project-docs.index') }}" class="btn btn-outline-dark">
                    Open Documentation
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card page-card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Latest Workflows</h4>
            <a href="{{ route('workflows.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
        </div>

        @if ($latestWorkflows->isEmpty())
            <div class="text-muted">
                No workflows yet. Create your first workflow to start testing the risk engine.
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Industry</th>
                        <th>Owner</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($latestWorkflows as $workflow)
                        <tr>
                            <td class="fw-semibold">{{ $workflow->title }}</td>
                            <td>{{ $workflow->industry ?: '-' }}</td>
                            <td>{{ $workflow->owner_name ?: '-' }}</td>
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
        @endif
    </div>
</div>
@endsection