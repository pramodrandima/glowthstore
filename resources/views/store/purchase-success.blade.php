<x-layouts.store>
    <h1 class="text-3xl font-bold">Purchase complete</h1>

    @if ($order->isPaid())
        <p class="mt-3 text-slate-700">Thank you for your purchase. Your files are ready below and also available in your account history.</p>

        <div class="mt-6 space-y-4">
            @foreach ($order->items as $item)
                <article class="rounded-xl border border-slate-200 bg-white p-4">
                    <h2 class="font-semibold">{{ $item->product->title }}</h2>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($item->product->files as $file)
                            <a href="{{ URL::temporarySignedRoute('downloads.file', now()->addHours(config('store.download_expiry_hours')), ['order' => $order->id, 'productFile' => $file->id]) }}" class="rounded bg-sky-600 px-3 py-2 text-sm text-white">Download {{ $file->display_name }}</a>
                        @endforeach
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <p class="mt-3 text-slate-700">Your payment is still being confirmed by webhook. Refresh this page in a few seconds.</p>
    @endif
</x-layouts.store>
