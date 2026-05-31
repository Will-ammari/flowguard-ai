@php
    $normalizedRiskLevel = strtolower($level ?: 'none');

    $riskClass = 'risk-none';

    if ($normalizedRiskLevel === 'critical') {
        $riskClass = 'risk-critical';
    } elseif ($normalizedRiskLevel === 'high') {
        $riskClass = 'risk-high';
    } elseif ($normalizedRiskLevel === 'medium') {
        $riskClass = 'risk-medium';
    } elseif ($normalizedRiskLevel === 'low') {
        $riskClass = 'risk-low';
    }
@endphp

<span class="badge {{ $riskClass }} {{ isset($class) ? $class : '' }}">
    {{ $level ?: 'None' }}
</span>