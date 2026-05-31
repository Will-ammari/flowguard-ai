<?php

namespace App\Domain\Risk\Rules;

use App\Domain\Risk\Contracts\RiskRule;
use App\Domain\Risk\DTO\RiskFindingData;
use App\Enums\ControlStatus;
use App\Enums\RiskCategory;
use App\Enums\RiskLevel;
use App\Models\Workflow;
use Illuminate\Support\Collection;

final class StoredPersonalDataRule implements RiskRule
{
    public function evaluate(Workflow $workflow, Collection $steps): array
    {
        $findings = [];

        foreach ($steps as $step) {
            if ($step->stores_data && $step->uses_personal_data) {
                $findings[] = new RiskFindingData(
                    $step->id,
                    'STORED_PERSONAL_DATA',
                    'Personal data is stored',
                    RiskLevel::MEDIUM,
                    'The workflow stores personal data, which requires access control and retention rules.',
                    'Define retention policy, access control, encryption strategy, and deletion workflow.',
                    'Add data retention fields, role-based access control, and scheduled cleanup jobs.',
                    ['storage_step' => $step->name],
                    RiskCategory::DATA_GOVERNANCE,
                    6,
                    ControlStatus::PARTIAL
                );
            }
        }

        return $findings;
    }
}
