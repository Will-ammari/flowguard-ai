<?php

namespace App\Domain\Risk\Rules;

use App\Domain\Risk\Contracts\RiskRule;
use App\Domain\Risk\DTO\RiskFindingData;
use App\Enums\ControlStatus;
use App\Enums\RiskCategory;
use App\Enums\RiskLevel;
use App\Models\Workflow;
use Illuminate\Support\Collection;

final class MissingFallbackRule implements RiskRule
{
    public function evaluate(Workflow $workflow, Collection $steps): array
    {
        $findings = [];

        foreach ($steps as $step) {
            if ($step->uses_ai && ! $step->has_fallback_path) {
                $findings[] = new RiskFindingData(
                    $step->id,
                    'MISSING_FALLBACK_PATH',
                    'No fallback path for AI failure',
                    RiskLevel::MEDIUM,
                    'The workflow does not define what happens if the AI component fails, times out, or returns low-confidence output.',
                    'Add fallback to a human queue, canned response, or safe retry policy.',
                    'Implement timeout handling, confidence thresholds, and escalation queues.',
                    ['fallback_needed' => true],
                    RiskCategory::RELIABILITY,
                    5,
                    ControlStatus::MISSING
                );
            }
        }

        return $findings;
    }
}
