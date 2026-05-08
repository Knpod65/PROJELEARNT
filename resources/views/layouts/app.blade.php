<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PDPA Data Management System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
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
