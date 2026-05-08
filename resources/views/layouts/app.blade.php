<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PDPA Data Management System')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-50 text-gray-900 antialiased">
    @include('partials.nav')

    <div class="min-h-screen">
        @include('partials.flash')

        <main class="max-w-7xl mx-auto px-4 py-8">
            @yield('content')
        </main>
    </div>

    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-600 text-sm">
            <p>&copy; {{ date('Y') }} PDPA Data Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
