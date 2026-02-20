<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Glowth Store' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <a class="text-xl font-bold" href="{{ route('home') }}">Glowth Store</a>
            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('shop') }}" class="hover:text-sky-600">Shop</a>
                <a href="{{ route('license') }}" class="hover:text-sky-600">License</a>
                <a href="{{ route('support') }}" class="hover:text-sky-600">Support</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded bg-sky-600 px-3 py-1.5 text-white">Account</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-sky-600">Login</a>
                    <a href="{{ route('register') }}" class="rounded bg-sky-600 px-3 py-1.5 text-white">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8">
        @if (session('status'))
            <div class="mb-6 rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="mt-16 border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-wrap gap-4 px-4 py-6 text-sm text-slate-600">
            <a href="{{ route('terms') }}">Terms</a>
            <a href="{{ route('privacy') }}">Privacy</a>
            <a href="{{ route('license') }}">License</a>
        </div>
    </footer>
</body>
</html>
