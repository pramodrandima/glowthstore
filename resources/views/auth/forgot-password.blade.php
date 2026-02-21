<x-layouts.store>
    <div class="mx-auto max-w-md">
        <div class="card p-6 md:p-8">
            <h1 class="text-2xl font-bold text-slate-900">Reset password</h1>
            <p class="mt-1 text-sm text-slate-600">Enter your email and we will send a reset link.</p>

            <x-auth-session-status class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-emerald-700" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label for="email" class="text-sm font-medium text-slate-800">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="store-input mt-1">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-600" />
                </div>

                <button class="btn-primary w-full">Email Password Reset Link</button>
            </form>

            <p class="mt-4 text-sm text-slate-600"><a href="{{ route('login') }}" class="underline hover:text-slate-900">Back to login</a></p>
        </div>
    </div>
</x-layouts.store>
