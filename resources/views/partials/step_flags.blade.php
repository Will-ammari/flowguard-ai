<div class="flag-list">
    @if ($step->uses_ai)
        <span class="badge bg-primary">AI</span>
    @endif

    @if ($step->uses_personal_data)
        <span class="badge text-bg-warning">Personal Data</span>
    @endif

    @if ($step->uses_sensitive_data)
        <span class="badge text-bg-danger">Sensitive Data</span>
    @endif

    @if ($step->has_human_review)
        <span class="badge text-bg-success">Human Review</span>
    @endif

    @if ($step->is_customer_facing)
        <span class="badge text-bg-info">Customer-facing</span>
    @endif

    @if ($step->uses_external_api)
        <span class="badge text-bg-secondary">External API</span>
    @endif

    @if ($step->stores_data)
        <span class="badge text-bg-dark">Stores Data</span>
    @endif

    @if ($step->has_audit_log)
        <span class="badge text-bg-success">Audit Log</span>
    @endif

    @if ($step->has_fallback_path)
        <span class="badge text-bg-success">Fallback</span>
    @endif

    @if ($step->is_irreversible_action)
        <span class="badge text-bg-danger">Irreversible</span>
    @endif
</div>