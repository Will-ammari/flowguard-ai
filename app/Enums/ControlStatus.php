<?php

namespace App\Enums;

final class ControlStatus
{
    const MISSING = 'Missing';
    const PARTIAL = 'Partial';
    const PRESENT = 'Present';
    const NOT_APPLICABLE = 'Not Applicable';

    public static function values()
    {
        return [
            self::MISSING,
            self::PARTIAL,
            self::PRESENT,
            self::NOT_APPLICABLE,
        ];
    }
}
