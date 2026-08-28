<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin APC</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex flex-column flex-lg-row">
        @include('partials.admin-sidebar')
        <div class="flex-grow-1 d-flex flex-column" style="min-height: 100vh;">
            @include('partials.admin-topbar')
            <main class="flex-grow-1 p-3 p-md-4">
                @include('partials.flash')
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
