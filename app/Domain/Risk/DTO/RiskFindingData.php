<?php

namespace App\Domain\Risk\DTO;

use App\Enums\ControlStatus;
use App\Enums\RiskCategory;

final class RiskFindingData
{
    public $workflowStepId;
    public $code;
    public $title;
    public $level;
    public $category;
    public $score;
    public $controlStatus;
    public $description;
    public $recommendation;
    public $engineeringControl;
    public $metadata;

    public function __construct(
        $workflowStepId,
        $code,
        $title,
        $level,
        $description,
        $recommendation,
        $engineeringControl,
        array $metadata = [],
        $category = RiskCategory::DATA_PRIVACY,
        $score = 5,
        $controlStatus = ControlStatus::MISSING
    ) {
        $this->workflowStepId = $workflowStepId;
        $this->code = $code;
        $this->title = $title;
        $this->level = $level;
        $this->category = $category;
        $this->score = max(1, min(10, (int) $score));
        $this->controlStatus = $controlStatus;
        $this->description = $description;
        $this->recommendation = $recommendation;
        $this->engineeringControl = $engineeringControl;
        $this->metadata = $metadata;
    }
}
