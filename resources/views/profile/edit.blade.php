<x-layouts.store>
    <div class="mb-8">
        <h1 class="section-title">{{ __('Profile Settings') }}</h1>
        <p class="muted mt-2 text-sm">{{ __('Manage your account details and security settings.') }}</p>
    </div>

    <div class="space-y-6">
            <div class="card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
    </div>
</x-layouts.store>
