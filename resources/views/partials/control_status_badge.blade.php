@php
    $normalizedStatus = strtolower($status ?: 'missing');

    $statusClass = 'control-missing';

    if ($normalizedStatus === 'present') {
        $statusClass = 'control-present';
    } elseif ($normalizedStatus === 'partial') {
        $statusClass = 'control-partial';
    } elseif ($normalizedStatus === 'not applicable') {
        $statusClass = 'control-na';
    }
@endphp

<span class="badge {{ $statusClass }} {{ isset($class) ? $class : '' }}">
    {{ $status ?: 'Missing' }}
</span>
