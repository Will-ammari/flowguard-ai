<?php

return [
    'risk_thresholds' => [
        'low' => 1,
        'medium' => 2,
        'high' => 3,
        'critical' => 4,
    ],
    'llm_provider' => env('LLM_PROVIDER', 'disabled'),
];
