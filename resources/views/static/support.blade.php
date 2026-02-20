<x-layouts.store>
    <h1 class="section-title">Support</h1>
    <p class="mt-2 text-slate-300">Need help with your purchase or files? Send a message and we will respond by email.</p>

    <form method="POST" action="{{ route('support.send') }}" class="glass mt-6 max-w-3xl space-y-4 p-6">
        @csrf
        <div>
            <label class="text-sm font-medium text-slate-200">Name</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}" class="store-input mt-1" required>
            @error('name') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium text-slate-200">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" class="store-input mt-1" required>
            @error('email') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium text-slate-200">Subject</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="store-input mt-1" required>
            @error('subject') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium text-slate-200">Message</label>
            <textarea name="message" rows="6" class="store-input mt-1" required>{{ old('message') }}</textarea>
            @error('message') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
        </div>
        <button class="btn-primary">Send Support Request</button>
    </form>
</x-layouts.store>
