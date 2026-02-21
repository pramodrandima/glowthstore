<x-layouts.store>
    <div class="mx-auto max-w-md">
        <div class="card p-6 md:p-8">
            <h1 class="text-2xl font-bold text-slate-900">Set new password</h1>
            <p class="mt-1 text-sm text-slate-600">Choose a secure password for your account.</p>

            <form method="POST" action="{{ route('password.store') }}" class="mt-5 space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="text-sm font-medium text-slate-800">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="store-input mt-1">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-600" />
                </div>

                <div>
                    <label for="password" class="text-sm font-medium text-slate-800">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password" class="store-input mt-1">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-600" />
                </div>

                <div>
                    <label for="password_confirmation" class="text-sm font-medium text-slate-800">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="store-input mt-1">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-rose-600" />
                </div>

                <button class="btn-primary w-full">Reset Password</button>
            </form>
        </div>
    </div>
</x-layouts.store>
