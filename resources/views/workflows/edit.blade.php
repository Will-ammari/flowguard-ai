@extends('layouts.app')

@section('title', 'Edit Workflow | FlowGuard AI')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <h1 class="fw-bold mb-1">Edit Workflow</h1>
                <p class="text-muted mb-0">
                    Update workflow metadata and business context.
                </p>
            </div>

            <div class="card page-card">
                <div class="card-body">
                    <form method="POST" action="{{ route('workflows.update', $workflow) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Workflow Title</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $workflow->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Industry</label>
                            <input type="text" name="industry" class="form-control"
                                value="{{ old('industry', $workflow->industry) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Owner / Team</label>
                            <input type="text" name="owner_name" class="form-control"
                                value="{{ old('owner_name', $workflow->owner_name) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $workflow->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Business Context</label>
                            <textarea name="business_context" class="form-control" rows="4">{{ old('business_context', $workflow->business_context) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('workflows.show', $workflow) }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-danger mt-4">
                <div class="card-body">
                    <h5 class="text-danger">Danger Zone</h5>
                    <p class="text-muted mb-3">
                        Deleting this workflow will also delete its steps, findings, and reports.
                    </p>

                    <form method="POST" action="{{ route('workflows.destroy', $workflow) }}"
                        data-confirm="Are you sure you want to delete this workflow? This action cannot be undone.">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-outline-danger">
                            Delete Workflow
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
