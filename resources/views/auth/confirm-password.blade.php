<x-layouts.store>
    <div class="mx-auto max-w-md">
        <div class="card p-6 md:p-8">
            <h1 class="text-2xl font-bold text-slate-900">Confirm password</h1>
            <p class="mt-1 text-sm text-slate-600">This is a secure area. Confirm your password to continue.</p>

            <form method="POST" action="{{ route('password.confirm') }}" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label for="password" class="text-sm font-medium text-slate-800">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" class="store-input mt-1">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-600" />
                </div>

                <button class="btn-primary w-full">Confirm</button>
            </form>
        </div>
    </div>
</x-layouts.store>
