<x-layouts.store>
    <h1 class="text-3xl font-bold">Your Orders</h1>

    <div class="mt-6 space-y-4">
        @forelse ($orders as $order)
            <article class="rounded-xl border border-slate-200 bg-white p-5">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h2 class="font-semibold">Order #{{ $order->id }}</h2>
                        <p class="text-sm text-slate-600">{{ $order->created_at->toDayDateTimeString() }} | {{ strtoupper($order->status->value) }}</p>
                    </div>
                    <a href="{{ route('account.orders.show', $order) }}" class="text-sm text-sky-600">View details</a>
                </div>
                <p class="mt-3 text-sm text-slate-700">Total: ${{ number_format($order->total_usd, 2) }}</p>
            </article>
        @empty
            <p class="text-slate-600">No orders yet.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
</x-layouts.store>
