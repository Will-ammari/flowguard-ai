<?php

namespace App\Domain\Risk\Rules;

use App\Domain\Risk\Contracts\RiskRule;
use App\Domain\Risk\DTO\RiskFindingData;
use App\Enums\ControlStatus;
use App\Enums\RiskCategory;
use App\Enums\RiskLevel;
use App\Enums\StepType;
use App\Models\Workflow;
use Illuminate\Support\Collection;

final class MissingHumanReviewRule implements RiskRule
{
    public function evaluate(Workflow $workflow, Collection $steps): array
    {
        $findings = [];

        foreach ($steps as $step) {
            if ($step->uses_ai && $step->is_customer_facing && ! $step->has_human_review) {
                $findings[] = new RiskFindingData(
                    $step->id,
                    'NO_HUMAN_OVERSIGHT',
                    'Customer-facing AI output without human review',
                    RiskLevel::HIGH,
                    'The AI system may produce customer-facing output without human approval.',
                    'Add a human approval step before sending AI-generated responses to customers.',
                    'Insert an approval queue with approve/reject/edit actions and immutable approval logs.',
                    ['requires_approval_queue' => true],
                    RiskCategory::HUMAN_OVERSIGHT,
                    8,
                    ControlStatus::MISSING
                );
            }
        }

        $usesAi = $steps->contains(function ($step) {
            return (bool) $step->uses_ai;
        });

        $hasDedicatedHumanReview = $steps->contains(function ($step) {
            return $step->step_type === StepType::HUMAN_REVIEW;
        });

        if ($usesAi && ! $hasDedicatedHumanReview) {
            $findings[] = new RiskFindingData(
                null,
                'MISSING_HUMAN_REVIEW_STEP',
                'No dedicated human review step found',
                RiskLevel::MEDIUM,
                'The workflow uses AI but does not include a clear human review or approval step.',
                'Add a dedicated human review step before irreversible or customer-facing actions.',
                'Model human review as a first-class workflow step and connect it to audit logging.',
                ['workflow_level' => true],
                RiskCategory::HUMAN_OVERSIGHT,
                6,
                ControlStatus::MISSING
            );
        }

        return $findings;
    }
}
