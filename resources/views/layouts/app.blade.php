<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FlowRead - Share books, spark conversations')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fffaf5;
        }
    </style>
    
    @yield('extra-head')
</head>
<body class="min-h-screen flex flex-col">

    <!-- Include Topbar -->
    @include('components.topbar')

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <div class="border-t border-orange-100 mt-12">
        <div class="container mx-auto px-4 py-6 max-w-7xl">
            <p class="text-center text-gray-500 text-sm">FlowRead - Keep the conversation flowing 📖</p>
        </div>
    </div>

    @yield('extra-scripts')
</body>
</html>