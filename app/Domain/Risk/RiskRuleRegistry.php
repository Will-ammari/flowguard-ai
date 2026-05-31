<?php

namespace App\Domain\Risk;

use App\Domain\Risk\Contracts\RiskRule;
use App\Domain\Risk\Rules\AiPersonalDataRule;
use App\Domain\Risk\Rules\CustomerFacingAiRule;
use App\Domain\Risk\Rules\IrreversibleAutomationRule;
use App\Domain\Risk\Rules\MissingAuditTrailRule;
use App\Domain\Risk\Rules\MissingFallbackRule;
use App\Domain\Risk\Rules\MissingHumanReviewRule;
use App\Domain\Risk\Rules\SensitiveDataAiExposureRule;
use App\Domain\Risk\Rules\StoredPersonalDataRule;
use App\Domain\Risk\Rules\ThirdPartyDataSharingRule;

final class RiskRuleRegistry
{
    /**
     * @return array<int, RiskRule>
     */
    public function rules(): array
    {
        return [
            new AiPersonalDataRule(),
            new CustomerFacingAiRule(),
            new MissingHumanReviewRule(),
            new ThirdPartyDataSharingRule(),
            new StoredPersonalDataRule(),
            new SensitiveDataAiExposureRule(),
            new MissingAuditTrailRule(),
            new MissingFallbackRule(),
            new IrreversibleAutomationRule(),
        ];
    }
}
