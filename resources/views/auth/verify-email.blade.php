<x-layouts.store>
    <div class="mx-auto max-w-md">
        <div class="card p-6 md:p-8">
            <h1 class="text-2xl font-bold text-slate-900">Verify your email</h1>
            <p class="mt-1 text-sm text-slate-600">Click the verification link in your inbox to activate your account.</p>

            @if (session('status') == 'verification-link-sent')
                <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <div class="mt-5 flex items-center justify-between gap-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button class="btn-primary">Resend Verification Email</button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-ghost">Logout</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.store>
