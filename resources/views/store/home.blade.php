<x-layouts.store>
    <section class="card overflow-hidden px-6 py-10 md:px-10 md:py-12">
        <div class="grid gap-8 md:grid-cols-2 md:items-center">
            <div>
                <span class="pill">Glowth-Only Creative Shop</span>
                <h1 class="mt-4 text-4xl font-bold leading-tight md:text-5xl">Bright assets. Fast checkout. Instant downloads.</h1>
                <p class="muted mt-4 max-w-xl">A clean digital storefront for templates, brand kits, and visual packs built for creators and agencies.</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('shop') }}" class="btn-primary">Browse Products</a>
                    <a href="{{ route('license') }}" class="btn-ghost">License</a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="card accent-mint p-4">
                    <p class="text-sm font-semibold text-slate-800">Instant Delivery</p>
                    <p class="mt-1 text-xs text-slate-700">Auto access after payment.</p>
                </div>
                <div class="card accent-lilac p-4">
                    <p class="text-sm font-semibold text-slate-800">Single License</p>
                    <p class="mt-1 text-xs text-slate-700">Simple usage terms.</p>
                </div>
                <div class="card accent-peach p-4">
                    <p class="text-sm font-semibold text-slate-800">Stripe Checkout</p>
                    <p class="mt-1 text-xs text-slate-700">Secure payment flow.</p>
                </div>
                <div class="card accent-sky p-4">
                    <p class="text-sm font-semibold text-slate-800">Order History</p>
                    <p class="mt-1 text-xs text-slate-700">Re-download from account.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-12">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="section-title">Featured Products</h2>
            <a href="{{ route('shop') }}" class="btn-ghost px-4 py-2">View All</a>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($featuredProducts as $product)
                @php
                    $preview = $product->previews->first();
                    $isUrl = $preview && str_starts_with($preview->image_path, 'http');
                @endphp
                <article class="product-card">
                    <a href="{{ route('product.show', $product->slug) }}" class="block">
                        @if ($preview)
                            <img src="{{ $isUrl ? $preview->image_path : Storage::disk('public')->url($preview->image_path) }}" class="h-52 w-full object-cover" alt="{{ $product->title }}">
                        @else
                            <div class="flex h-52 items-center justify-center bg-slate-100 text-slate-500">No preview</div>
                        @endif
                    </a>
                    <div class="p-5">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-500">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                        <h3 class="mt-2 text-lg font-semibold text-slate-900"><a href="{{ route('product.show', $product->slug) }}">{{ $product->title }}</a></h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $product->short_description }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xl font-bold text-slate-900">${{ number_format($product->price_usd, 2) }}</span>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn-ghost px-4 py-2 text-xs">Details</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</x-layouts.store>
