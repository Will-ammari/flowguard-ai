<?php

namespace App\Enums;

final class RiskCategory
{
    const DATA_PRIVACY = 'Data Privacy';
    const HUMAN_OVERSIGHT = 'Human Oversight';
    const TRACEABILITY = 'Traceability';
    const THIRD_PARTY = 'Third Party';
    const RELIABILITY = 'Reliability';
    const SAFETY = 'Safety';
    const DATA_GOVERNANCE = 'Data Governance';

    public static function values()
    {
        return [
            self::DATA_PRIVACY,
            self::HUMAN_OVERSIGHT,
            self::TRACEABILITY,
            self::THIRD_PARTY,
            self::RELIABILITY,
            self::SAFETY,
            self::DATA_GOVERNANCE,
        ];
    }
}
