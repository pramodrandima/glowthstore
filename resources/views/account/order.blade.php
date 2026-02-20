<x-layouts.store>
    <h1 class="section-title">Order #{{ $order->id }}</h1>
    <p class="mt-2 text-slate-600">Status: {{ strtoupper($order->status->value) }} · Total: ${{ number_format($order->total_usd, 2) }}</p>

    <div class="mt-6 space-y-4">
        @foreach ($order->items as $item)
            <article class="card p-5">
                <h2 class="font-semibold text-slate-900">{{ $item->product->title }}</h2>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($item->product->files as $file)
                        <a href="{{ URL::temporarySignedRoute('downloads.file', now()->addHours(config('store.download_expiry_hours')), ['order' => $order->id, 'productFile' => $file->id]) }}" class="btn-primary px-4 py-2 text-xs">Download {{ $file->display_name }}</a>
                    @endforeach
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-semibold text-slate-900">Download History</h2>
        <div class="mt-3 card p-4">
            @forelse ($order->downloadEvents as $event)
                <p class="text-sm text-slate-600">{{ $event->created_at->toDayDateTimeString() }} · File #{{ $event->product_file_id }} · {{ $event->ip }}</p>
            @empty
                <p class="text-sm text-slate-500">No downloads yet.</p>
            @endforelse
        </div>
    </div>
</x-layouts.store>
