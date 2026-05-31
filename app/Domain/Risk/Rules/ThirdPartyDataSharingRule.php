<?php

namespace App\Domain\Risk\Rules;

use App\Domain\Risk\Contracts\RiskRule;
use App\Domain\Risk\DTO\RiskFindingData;
use App\Enums\ControlStatus;
use App\Enums\RiskCategory;
use App\Enums\RiskLevel;
use App\Models\Workflow;
use Illuminate\Support\Collection;

final class ThirdPartyDataSharingRule implements RiskRule
{
    public function evaluate(Workflow $workflow, Collection $steps): array
    {
        $findings = [];

        foreach ($steps as $step) {
            if ($step->uses_external_api && $step->uses_personal_data) {
                $findings[] = new RiskFindingData(
                    $step->id,
                    'THIRD_PARTY_DATA_SHARING',
                    'Personal data shared with a third-party service',
                    RiskLevel::MEDIUM,
                    'This step may send personal data to an external API or third-party processor.',
                    'Document the third-party service, data categories, processing purpose, and retention behavior.',
                    'Maintain a processor registry and add request-level logging for third-party calls.',
                    ['systems_involved' => $step->systems_involved ?: []],
                    RiskCategory::THIRD_PARTY,
                    6,
                    ControlStatus::PARTIAL
                );
            }
        }

        return $findings;
    }
}
