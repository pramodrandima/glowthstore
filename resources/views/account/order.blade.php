<x-layouts.store>
    <h1 class="text-3xl font-bold">Order #{{ $order->id }}</h1>
    <p class="mt-2 text-slate-700">Status: {{ strtoupper($order->status->value) }} | Total: ${{ number_format($order->total_usd, 2) }}</p>

    <div class="mt-6 space-y-4">
        @foreach ($order->items as $item)
            <article class="rounded-xl border border-slate-200 bg-white p-5">
                <h2 class="font-semibold">{{ $item->product->title }}</h2>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($item->product->files as $file)
                        <a href="{{ URL::temporarySignedRoute('downloads.file', now()->addHours(config('store.download_expiry_hours')), ['order' => $order->id, 'productFile' => $file->id]) }}" class="rounded bg-sky-600 px-3 py-2 text-sm text-white">Download {{ $file->display_name }}</a>
                    @endforeach
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-semibold">Download History</h2>
        <div class="mt-3 rounded-xl border border-slate-200 bg-white p-4">
            @forelse ($order->downloadEvents as $event)
                <p class="text-sm text-slate-700">{{ $event->created_at->toDayDateTimeString() }} - File #{{ $event->product_file_id }} - {{ $event->ip }}</p>
            @empty
                <p class="text-sm text-slate-600">No downloads yet.</p>
            @endforelse
        </div>
    </div>
</x-layouts.store>
