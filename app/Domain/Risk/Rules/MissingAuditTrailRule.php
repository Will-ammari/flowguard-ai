<?php

namespace App\Domain\Risk\Rules;

use App\Domain\Risk\Contracts\RiskRule;
use App\Domain\Risk\DTO\RiskFindingData;
use App\Enums\ControlStatus;
use App\Enums\RiskCategory;
use App\Enums\RiskLevel;
use App\Models\Workflow;
use Illuminate\Support\Collection;

final class MissingAuditTrailRule implements RiskRule
{
    public function evaluate(Workflow $workflow, Collection $steps): array
    {
        $findings = [];

        foreach ($steps as $step) {
            if (($step->uses_ai || $step->is_irreversible_action) && ! $step->has_audit_log) {
                $findings[] = new RiskFindingData(
                    $step->id,
                    'MISSING_AUDIT_TRAIL',
                    'Missing audit trail for AI or irreversible action',
                    RiskLevel::MEDIUM,
                    'This step should be traceable because it involves AI processing or an action that is hard to reverse.',
                    'Log inputs, outputs, model/provider metadata, approvals, timestamps, and final action status.',
                    'Create an append-only audit_logs table and log every AI/tool/action event.',
                    ['audit_required' => true],
                    RiskCategory::TRACEABILITY,
                    6,
                    ControlStatus::MISSING
                );
            }
        }

        return $findings;
    }
}
