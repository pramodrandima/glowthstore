<x-layouts.store>
    <div class="mx-auto max-w-md">
        <div class="card p-6 md:p-8">
            <h1 class="text-2xl font-bold text-slate-900">Create your account</h1>
            <p class="mt-1 text-sm text-slate-600">Register to purchase and manage downloads.</p>

            <form method="POST" action="{{ route('register') }}" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label for="name" class="text-sm font-medium text-slate-800">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" class="store-input mt-1">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-rose-600" />
                </div>

                <div>
                    <label for="email" class="text-sm font-medium text-slate-800">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" class="store-input mt-1">
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

                <button class="btn-primary w-full">Register</button>
            </form>

            <p class="mt-4 text-sm text-slate-600">
                Already have an account?
                <a href="{{ route('login') }}" class="underline hover:text-slate-900">Log in</a>
            </p>
        </div>
    </div>
</x-layouts.store>
