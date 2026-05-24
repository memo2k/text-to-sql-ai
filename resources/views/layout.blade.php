<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="@yield('theme', 'light')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('head')
</head>
<body class="flex min-h-screen flex-col bg-base-200 font-sans antialiased @yield('body-class')">
    @hasSection('header')
        @yield('header')
    @else
        <x-header class="shrink-0" />
    @endif

    <div class="flex flex-1 flex-col">
        @yield('content')
    </div>

    @hasSection('footer')
        @yield('footer')
    @else
        <x-footer class="mt-auto shrink-0" />
    @endif

    @stack('scripts')
</body>
</html>
