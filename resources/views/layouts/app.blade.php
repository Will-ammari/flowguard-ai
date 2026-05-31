<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'FlowGuard AI')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Vendor CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Application CSS --}}
    <link href="{{ asset('css/flowguard.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark no-print">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">FlowGuard AI</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="mainNavbar" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('workflows.index') }}" class="nav-link">Workflows</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('case-study.show') }}" class="nav-link">Case Study</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('about-project.show') }}" class="nav-link">About</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('project-docs.index') }}" class="nav-link">Docs</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('workflows.create') }}" class="nav-link">New Workflow</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    @include('partials.alerts')

    @yield('content')
</main>

{{-- Vendor JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Application JS --}}
<script src="{{ asset('js/flowguard.js') }}"></script>

@stack('scripts')
</body>
</html>