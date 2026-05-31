<?php

namespace App\Domain\Risk\Contracts;

use App\Domain\Risk\DTO\RiskFindingData;
use App\Models\Workflow;
use Illuminate\Support\Collection;

interface RiskRule
{
    /**
     * @param Collection<int, \App\Models\WorkflowStep> $steps
     * @return array<int, RiskFindingData>
     */
    public function evaluate(Workflow $workflow, Collection $steps): array;
}
