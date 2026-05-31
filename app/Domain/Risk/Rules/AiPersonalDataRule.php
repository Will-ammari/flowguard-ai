<?php

namespace App\Domain\Risk\Rules;

use App\Domain\Risk\Contracts\RiskRule;
use App\Domain\Risk\DTO\RiskFindingData;
use App\Enums\ControlStatus;
use App\Enums\RiskCategory;
use App\Enums\RiskLevel;
use App\Models\Workflow;
use Illuminate\Support\Collection;

final class AiPersonalDataRule implements RiskRule
{
    public function evaluate(Workflow $workflow, Collection $steps): array
    {
        $findings = [];

        foreach ($steps as $step) {
            if ($step->uses_ai && $step->uses_personal_data) {
                $findings[] = new RiskFindingData(
                    $step->id,
                    'AI_PERSONAL_DATA',
                    'Personal data is processed by an AI component',
                    RiskLevel::MEDIUM,
                    'This workflow step sends or processes personal data using an AI system.',
                    'Minimize, redact, or tokenize personal data before sending it to the AI component.',
                    'Add a pre-processing layer that removes emails, phone numbers, addresses, IDs, and free-text sensitive fields before LLM calls.',
                    ['step_type' => $step->step_type],
                    RiskCategory::DATA_PRIVACY,
                    6,
                    ControlStatus::PARTIAL
                );
            }
        }

        return $findings;
    }
}
