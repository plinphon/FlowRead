<nav class="bg-white border-b border-orange-200 sticky top-0 z-50">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <a href="{{ route('books.list') }}" class="flex items-center gap-2">
                <span class="text-2xl font-bold text-orange-500">FlowRead</span>
            </a>

            <!-- Right Side: Auth Buttons -->
            <div class="flex items-center gap-3">
                @auth
                    <!-- Logged in user -->
                    <div class="flex items-center gap-3">
                        <!-- User Avatar & Name -->
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-semibold">
                                {{ strtoupper(substr(Auth::user()->username ?? Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-700 hidden sm:block">
                                {{ Auth::user()->username ?? Auth::user()->name ?? 'User' }}
                            </span>
                        </div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Guest buttons -->
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition text-sm font-medium">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>