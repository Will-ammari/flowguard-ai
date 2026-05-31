<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalysisReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'workflow_id',
        'overall_risk_level',
        'summary',
        'report_payload',
    ];

    protected $casts = [
        'report_payload' => 'array',
    ];

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }
}
