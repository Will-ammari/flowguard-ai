<?php

namespace App\Enums;

final class StepType
{
    const USER_INPUT = 'user_input';
    const WEBHOOK = 'webhook';
    const DATABASE_STORAGE = 'database_storage';
    const AI_PROCESSING = 'ai_processing';
    const HUMAN_REVIEW = 'human_review';
    const EXTERNAL_API = 'external_api';
    const MESSAGE_SENDING = 'message_sending';
    const DECISION = 'decision';
    const FILE_PROCESSING = 'file_processing';

    public static function values()
    {
        return [
            self::USER_INPUT,
            self::WEBHOOK,
            self::DATABASE_STORAGE,
            self::AI_PROCESSING,
            self::HUMAN_REVIEW,
            self::EXTERNAL_API,
            self::MESSAGE_SENDING,
            self::DECISION,
            self::FILE_PROCESSING,
        ];
    }
}
