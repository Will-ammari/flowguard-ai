<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="fw-bold mb-1">{{ $title }}</h1>

        @if (!empty($subtitle))
            <div class="text-muted">
                {{ $subtitle }}
            </div>
        @endif
    </div>

    @if (!empty($actions))
        <div class="d-flex gap-2 flex-wrap justify-content-end">
            {!! $actions !!}
        </div>
    @endif
</div>