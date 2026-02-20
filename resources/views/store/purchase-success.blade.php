<x-layouts.store>
    <div class="glass p-6 md:p-8">
        <h1 class="text-3xl font-bold text-white">Purchase Complete</h1>

        @if ($order->isPaid())
            <p class="mt-3 text-slate-300">Your payment is confirmed. Download links are active and available in your account order history.</p>

            <div class="mt-6 space-y-4">
                @foreach ($order->items as $item)
                    <article class="glass p-4">
                        <h2 class="font-semibold text-slate-100">{{ $item->product->title }}</h2>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($item->product->files as $file)
                                <a href="{{ URL::temporarySignedRoute('downloads.file', now()->addHours(config('store.download_expiry_hours')), ['order' => $order->id, 'productFile' => $file->id]) }}" class="btn-primary px-4 py-2 text-xs">Download {{ $file->display_name }}</a>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="mt-3 text-slate-300">Payment is being confirmed via webhook. Refresh in a few seconds.</p>
        @endif
    </div>
</x-layouts.store>
