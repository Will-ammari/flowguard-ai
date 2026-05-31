<?php

namespace App\Domain\Risk\Rules;

use App\Domain\Risk\Contracts\RiskRule;
use App\Domain\Risk\DTO\RiskFindingData;
use App\Enums\ControlStatus;
use App\Enums\RiskCategory;
use App\Enums\RiskLevel;
use App\Models\Workflow;
use Illuminate\Support\Collection;

final class SensitiveDataAiExposureRule implements RiskRule
{
    public function evaluate(Workflow $workflow, Collection $steps): array
    {
        $findings = [];

        foreach ($steps as $step) {
            if ($step->uses_sensitive_data && $step->uses_ai) {
                $findings[] = new RiskFindingData(
                    $step->id,
                    'SENSITIVE_DATA_AI_EXPOSURE',
                    'Sensitive data may be exposed to AI processing',
                    RiskLevel::HIGH,
                    'Sensitive data is processed by an AI component, increasing privacy and safety risk.',
                    'Block, mask, redact, or route sensitive data to a human-only workflow before AI processing.',
                    'Implement sensitive entity detection and a hard-stop policy before LLM requests.',
                    ['sensitive_data' => true],
                    RiskCategory::DATA_PRIVACY,
                    9,
                    ControlStatus::MISSING
                );
            }
        }

        return $findings;
    }
}
