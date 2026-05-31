<?php

namespace App\Enums;

final class RiskLevel
{
    const NONE = 'None';
    const LOW = 'Low';
    const MEDIUM = 'Medium';
    const HIGH = 'High';
    const CRITICAL = 'Critical';

    public static function weight($level)
    {
        switch ($level) {
            case self::LOW:
                return 1;
            case self::MEDIUM:
                return 2;
            case self::HIGH:
                return 3;
            case self::CRITICAL:
                return 4;
            case self::NONE:
            default:
                return 0;
        }
    }

    public static function values()
    {
        return [self::NONE, self::LOW, self::MEDIUM, self::HIGH, self::CRITICAL];
    }
}
