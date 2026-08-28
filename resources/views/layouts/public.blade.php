<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('title')
        <title>@yield('title') — {{ \App\Support\Settings::get('business_short', 'APC') }}</title>
    @else
        <title>{{ \App\Support\Settings::get('business_name', 'APC') }}</title>
    @endif

    @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')">
    @else
        <meta name="description" content="{{ \App\Support\Settings::get('tagline') }}">
    @endif

    <meta property="og:site_name" content="{{ \App\Support\Settings::get('business_name') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif
    @hasSection('meta_title')
        <meta property="og:title" content="@yield('meta_title')">
    @endif
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100 bg-white">
    @include('partials.public-navbar')

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('partials.public-footer')

    @stack('scripts')
</body>
</html>
