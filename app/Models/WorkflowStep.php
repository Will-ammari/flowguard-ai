<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkflowStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'workflow_id',
        'step_order',
        'name',
        'step_type',
        'description',
        'input_data',
        'output_data',
        'systems_involved',
        'uses_ai',
        'uses_personal_data',
        'has_human_review',
        'is_customer_facing',
        'uses_external_api',
        'stores_data',
        'uses_sensitive_data',
        'has_audit_log',
        'has_fallback_path',
        'is_irreversible_action',
    ];

    protected $casts = [
        'input_data' => 'array',
        'output_data' => 'array',
        'systems_involved' => 'array',
        'uses_ai' => 'boolean',
        'uses_personal_data' => 'boolean',
        'has_human_review' => 'boolean',
        'is_customer_facing' => 'boolean',
        'uses_external_api' => 'boolean',
        'stores_data' => 'boolean',
        'uses_sensitive_data' => 'boolean',
        'has_audit_log' => 'boolean',
        'has_fallback_path' => 'boolean',
        'is_irreversible_action' => 'boolean',
    ];

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    public function riskFindings(): HasMany
    {
        return $this->hasMany(RiskFinding::class);
    }
}
