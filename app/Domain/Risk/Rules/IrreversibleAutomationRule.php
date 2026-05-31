<?php

namespace App\Domain\Risk\Rules;

use App\Domain\Risk\Contracts\RiskRule;
use App\Domain\Risk\DTO\RiskFindingData;
use App\Enums\ControlStatus;
use App\Enums\RiskCategory;
use App\Enums\RiskLevel;
use App\Models\Workflow;
use Illuminate\Support\Collection;

final class IrreversibleAutomationRule implements RiskRule
{
    public function evaluate(Workflow $workflow, Collection $steps): array
    {
        $findings = [];

        foreach ($steps as $step) {
            if ($step->is_irreversible_action && ! $step->has_human_review) {
                $findings[] = new RiskFindingData(
                    $step->id,
                    'IRREVERSIBLE_AUTOMATION_WITHOUT_APPROVAL',
                    'Irreversible action without approval gate',
                    RiskLevel::HIGH,
                    'This automated step performs an action that may be difficult to reverse without human approval.',
                    'Add an approval gate before irreversible actions such as sending messages, submitting forms, or updating external systems.',
                    'Use a command queue with pending/approved/rejected states and idempotency keys.',
                    ['approval_gate_required' => true],
                    RiskCategory::SAFETY,
                    8,
                    ControlStatus::MISSING
                );
            }
        }

        return $findings;
    }
}
