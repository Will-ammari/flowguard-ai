<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskFinding extends Model
{
    use HasFactory;

    protected $fillable = [
        'workflow_id',
        'workflow_step_id',
        'risk_code',
        'risk_title',
        'risk_level',
        'risk_category',
        'risk_score',
        'control_status',
        'description',
        'recommendation',
        'engineering_control',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'risk_score' => 'integer',
    ];

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    public function workflowStep(): BelongsTo
    {
        return $this->belongsTo(WorkflowStep::class);
    }
}
