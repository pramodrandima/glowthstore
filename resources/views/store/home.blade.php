<x-layouts.store>
    <section class="rounded-2xl bg-gradient-to-r from-sky-600 to-cyan-600 px-8 py-16 text-white">
        <h1 class="text-4xl font-bold">Glowth Store Digital Assets</h1>
        <p class="mt-4 max-w-2xl text-lg text-sky-50">Premium Glowth design resources with instant delivery, secure downloads, and a clean one-license buying flow.</p>
        <a href="{{ route('shop') }}" class="mt-8 inline-block rounded bg-white px-5 py-3 font-semibold text-sky-700">Browse Products</a>
    </section>

    <section class="mt-12">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-2xl font-semibold">Featured Products</h2>
            <a href="{{ route('shop') }}" class="text-sm text-sky-600">View all</a>
        </div>
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($featuredProducts as $product)
                @php
                    $preview = $product->previews->first();
                    $isUrl = $preview && str_starts_with($preview->image_path, 'http');
                @endphp
                <article class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                    <a href="{{ route('product.show', $product->slug) }}">
                        @if ($preview)
                            <img src="{{ $isUrl ? $preview->image_path : Storage::disk('public')->url($preview->image_path) }}" class="h-48 w-full object-cover" alt="{{ $product->title }}">
                        @else
                            <div class="flex h-48 items-center justify-center bg-slate-100 text-slate-500">No preview</div>
                        @endif
                    </a>
                    <div class="p-4">
                        <p class="text-xs uppercase text-slate-500">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                        <h3 class="mt-1 text-lg font-semibold"><a href="{{ route('product.show', $product->slug) }}">{{ $product->title }}</a></h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $product->short_description }}</p>
                        <p class="mt-3 text-lg font-bold">${{ number_format($product->price_usd, 2) }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</x-layouts.store>
