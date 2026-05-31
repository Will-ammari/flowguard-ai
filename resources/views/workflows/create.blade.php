@extends('layouts.app')

@section('title', 'Create Workflow | FlowGuard AI')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <h1 class="fw-bold mb-1">Create Workflow</h1>
            <p class="text-muted mb-0">
                Define the business workflow that will be analyzed by the risk engine.
            </p>
        </div>

        <div class="card page-card">
            <div class="card-body">
                <form method="POST" action="{{ route('workflows.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Workflow Title</label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            value="{{ old('title') }}"
                            placeholder="AI-assisted WhatsApp Customer Support"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Industry</label>
                        <input
                            type="text"
                            name="industry"
                            class="form-control"
                            value="{{ old('industry') }}"
                            placeholder="Retail, Healthcare, SaaS, Education..."
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Owner / Team</label>
                        <input
                            type="text"
                            name="owner_name"
                            class="form-control"
                            value="{{ old('owner_name') }}"
                            placeholder="Operations Team"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea
                            name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Describe what this workflow does."
                        >{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Business Context</label>
                        <textarea
                            name="business_context"
                            class="form-control"
                            rows="4"
                            placeholder="Why does the business use this automation? What decisions or customer interactions does it support?"
                        >{{ old('business_context') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('workflows.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Create Workflow
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection