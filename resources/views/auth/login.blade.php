<x-layouts.store>
    <div class="mx-auto max-w-md">
        <div class="card p-6 md:p-8">
            <h1 class="text-2xl font-bold text-slate-900">Welcome back</h1>
            <p class="mt-1 text-sm text-slate-600">Log in to access orders and downloads.</p>

            <x-auth-session-status class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-emerald-700" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label for="email" class="text-sm font-medium text-slate-800">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="store-input mt-1">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-600" />
                </div>

                <div>
                    <label for="password" class="text-sm font-medium text-slate-800">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" class="store-input mt-1">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-600" />
                </div>

                <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Remember me
                </label>

                <button class="btn-primary w-full">Log in</button>
            </form>

            <div class="mt-4 flex items-center justify-between text-sm">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-slate-600 underline hover:text-slate-900">Forgot password?</a>
                @endif
                <a href="{{ route('register') }}" class="text-slate-600 underline hover:text-slate-900">Create account</a>
            </div>
        </div>
    </div>
</x-layouts.store>
