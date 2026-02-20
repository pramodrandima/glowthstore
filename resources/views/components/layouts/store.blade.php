<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Glowth Store' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="sticky top-0 z-40 border-b border-[#dccff0] bg-[#f7f2fd]/90 backdrop-blur">
        <div class="shell flex items-center justify-between py-4">
            <a class="flex items-center gap-2 text-lg font-bold text-slate-900" href="{{ route('home') }}">
                <span class="h-2.5 w-2.5 rounded-full bg-indigo-400"></span>
                Glowth Store
            </a>

            <nav class="hidden items-center gap-5 text-sm text-slate-600 md:flex">
                <a href="{{ route('shop') }}" class="hover:text-slate-900">Shop</a>
                <a href="{{ route('license') }}" class="hover:text-slate-900">License</a>
                <a href="{{ route('support') }}" class="hover:text-slate-900">Support</a>
            </nav>

            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-ghost px-4 py-2">Account</a>
                    <a href="{{ route('profile.edit') }}" class="btn-ghost px-4 py-2">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-ghost px-4 py-2">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost px-4 py-2">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary px-4 py-2">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="shell py-8 md:py-10">
        @if (session('status'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="mt-14 border-t border-[#dccff0] py-8 text-sm text-slate-600">
        <div class="shell flex flex-wrap items-center justify-between gap-3">
            <p>Glowth Store · Digital product library</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('terms') }}" class="hover:text-slate-900">Terms</a>
                <a href="{{ route('privacy') }}" class="hover:text-slate-900">Privacy</a>
                <a href="{{ route('license') }}" class="hover:text-slate-900">License</a>
            </div>
        </div>
    </footer>
</body>
</html>
