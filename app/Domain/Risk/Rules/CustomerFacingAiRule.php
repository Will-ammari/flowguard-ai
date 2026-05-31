<?php

namespace App\Domain\Risk\Rules;

use App\Domain\Risk\Contracts\RiskRule;
use App\Domain\Risk\DTO\RiskFindingData;
use App\Enums\ControlStatus;
use App\Enums\RiskCategory;
use App\Enums\RiskLevel;
use App\Models\Workflow;
use Illuminate\Support\Collection;

final class CustomerFacingAiRule implements RiskRule
{
    public function evaluate(Workflow $workflow, Collection $steps): array
    {
        $findings = [];

        foreach ($steps as $step) {
            if ($step->uses_ai && $step->is_customer_facing) {
                $findings[] = new RiskFindingData(
                    $step->id,
                    'CUSTOMER_FACING_AI',
                    'Customer-facing AI output detected',
                    RiskLevel::MEDIUM,
                    'The customer may receive output generated or assisted by an AI system.',
                    'Add a clear disclosure that AI assistance may be used and provide an escalation path to a human agent.',
                    'Add a disclosure banner/message and store a disclosure_sent flag in the conversation metadata.',
                    ['customer_facing' => true],
                    RiskCategory::HUMAN_OVERSIGHT,
                    5,
                    ControlStatus::PARTIAL
                );
            }
        }

        return $findings;
    }
}
