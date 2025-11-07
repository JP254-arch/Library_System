<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Lexicon') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-white shadow-md sticky top-0 z-20">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="h-8 w-8 rounded-full object-cover">
                <span class="font-bold text-indigo-600 text-lg">{{ config('app.name', 'Lexicon') }}</span>
            </a>

            {{-- Navigation --}}
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
                <a href="{{ route('books.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Books</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-indigo-600 font-medium">About</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Contact</a>

                @auth
                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'librarian')
                        <a href="{{ route('books.create') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Add Book</a>
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Dashboard</a>
                    @elseif(auth()->user()->role === 'member')
                        <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Dashboard</a>
                        <a href="{{ route('loans.my') }}" class="text-gray-700 hover:text-indigo-600 font-medium">My Loans</a>
                    @endif

                    <div class="flex items-center space-x-3 border-l pl-4">
                        <span class="font-semibold text-gray-700">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-600 font-medium">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow py-12 px-4">
        <div class="w-full max-w-6xl mx-auto">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="p-4 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-red-800 bg-red-100 border border-red-300 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('info'))
                <div class="p-4 mb-4 text-blue-800 bg-blue-100 border border-blue-300 rounded-md">
                    {{ session('info') }}
                </div>
            @endif

            {{-- Page content --}}
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t py-4 mt-auto">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            © {{ date('Y') }} {{ config('app.name', 'Lexicon') }}. All rights reserved.
        </div>
    </footer>

</body>

</html>
