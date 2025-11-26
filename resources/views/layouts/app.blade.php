<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowRead</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <nav class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between">
            <a href="/" class="font-bold text-xl">FlowRead</a>
            <div>
                @auth
                    <span class="mr-4">{{ auth()->user()->username }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mr-4">Login</a>
                    <a href="{{ route('register') }}" class="bg-green-500 text-white px-3 py-1 rounded">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-10">
        @yield('content')
    </main>
</body>
</html>
