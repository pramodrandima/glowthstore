<x-layouts.store>
    <h1 class="section-title">Your Orders</h1>

    <div class="mt-6 space-y-4">
        @forelse ($orders as $order)
            <article class="card p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Order #{{ $order->id }}</h2>
                        <p class="text-sm text-slate-500">{{ $order->created_at->toDayDateTimeString() }} · {{ strtoupper($order->status->value) }}</p>
                    </div>
                    <a href="{{ route('account.orders.show', $order) }}" class="btn-ghost px-4 py-2 text-xs">View Details</a>
                </div>
                <p class="mt-3 text-sm text-slate-700">Total: <span class="font-semibold text-slate-900">${{ number_format($order->total_usd, 2) }}</span></p>
            </article>
        @empty
            <div class="card p-6 text-slate-600">No orders yet.</div>
        @endforelse
    </div>

    <div class="mt-8">{{ $orders->links() }}</div>
</x-layouts.store>
