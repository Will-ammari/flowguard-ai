@extends('layouts.app')

@section('title', 'Edit Workflow Step | FlowGuard AI')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="mb-4">
                <h1 class="fw-bold mb-1">Edit Workflow Step</h1>
                <p class="text-muted mb-0">
                    Workflow: <strong>{{ $workflow->title }}</strong>
                </p>
            </div>

            <div class="card page-card">
                <div class="card-body">
                    <form method="POST" action="{{ route('workflow-steps.update', [$workflow, $workflowStep]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Step Order</label>
                                <input type="number" name="step_order" class="form-control"
                                    value="{{ old('step_order', $workflowStep->step_order) }}" min="1" required>
                            </div>

                            <div class="col-md-9 mb-3">
                                <label class="form-label">Step Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $workflowStep->name) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Step Type</label>
                            <select name="step_type" class="form-select" required>
                                @foreach ($stepTypes as $stepType)
                                    <option value="{{ $stepType }}" @if (old('step_type', $workflowStep->step_type) === $stepType) selected @endif>
                                        {{ $stepType }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $workflowStep->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Input Data</label>
                                <input type="text" name="input_data" class="form-control"
                                    value="{{ old('input_data', implode(', ', $workflowStep->input_data ?: [])) }}">
                                <div class="form-help">Comma-separated values.</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Output Data</label>
                                <input type="text" name="output_data" class="form-control"
                                    value="{{ old('output_data', implode(', ', $workflowStep->output_data ?: [])) }}">
                                <div class="form-help">Comma-separated values.</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Systems Involved</label>
                                <input type="text" name="systems_involved" class="form-control"
                                    value="{{ old('systems_involved', implode(', ', $workflowStep->systems_involved ?: [])) }}">
                                <div class="form-help">Comma-separated values.</div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3">Engineering Flags</h5>

                        @php
                            $flags = [
                                'uses_ai' => 'Uses AI',
                                'uses_personal_data' => 'Uses personal data',
                                'has_human_review' => 'Has human review',
                                'is_customer_facing' => 'Customer-facing',
                                'uses_external_api' => 'Uses external API',
                                'stores_data' => 'Stores data',
                                'uses_sensitive_data' => 'Uses sensitive data',
                                'has_audit_log' => 'Has audit log',
                                'has_fallback_path' => 'Has fallback path',
                                'is_irreversible_action' => 'Irreversible action',
                            ];
                        @endphp

                        <div class="row">
                            @foreach ($flags as $name => $label)
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="{{ $name }}"
                                            value="1" id="{{ $name }}"
                                            @if (old($name, $workflowStep->{$name})) checked @endif>
                                        <label class="form-check-label" for="{{ $name }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('workflows.show', $workflow) }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Save Step
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-danger mt-4">
                <div class="card-body">
                    <h5 class="text-danger">Delete Step</h5>
                    <p class="text-muted mb-3">
                        Deleting this step will clear current analysis results. Run analysis again after deletion.
                    </p>

                    <form method="POST" action="{{ route('workflow-steps.destroy', [$workflow, $workflowStep]) }}"
                        data-confirm="Are you sure you want to delete this workflow step?">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-outline-danger">
                            Delete Step
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
