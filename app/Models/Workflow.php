<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'industry',
        'owner_name',
        'business_context',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(WorkflowStep::class)->orderBy('step_order');
    }

    public function riskFindings(): HasMany
    {
        return $this->hasMany(RiskFinding::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(AnalysisReport::class);
    }
}
