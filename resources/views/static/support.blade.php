<x-layouts.store>
    <h1 class="text-3xl font-bold">Support</h1>
    <p class="mt-2 text-slate-700">Need help with your purchase or files? Send a message and we will respond by email.</p>

    <form method="POST" action="{{ route('support.send') }}" class="mt-6 max-w-2xl space-y-4 rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        <div>
            <label class="text-sm font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}" class="mt-1 w-full rounded border-slate-300" required>
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" class="mt-1 w-full rounded border-slate-300" required>
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium">Subject</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="mt-1 w-full rounded border-slate-300" required>
            @error('subject') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium">Message</label>
            <textarea name="message" rows="6" class="mt-1 w-full rounded border-slate-300" required>{{ old('message') }}</textarea>
            @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <button class="rounded bg-sky-600 px-4 py-2 font-medium text-white">Send support request</button>
    </form>
</x-layouts.store>
