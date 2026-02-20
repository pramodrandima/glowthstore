<x-layouts.store>
    @php
        $inclusions = $product->inclusions ?? [];
    @endphp

    <div class="grid gap-7 lg:grid-cols-[1.08fr_1fr]">
        <section class="space-y-4">
            @forelse ($product->previews as $preview)
                @php($isUrl = str_starts_with($preview->image_path, 'http'))
                <img src="{{ $isUrl ? $preview->image_path : Storage::disk('public')->url($preview->image_path) }}" alt="Preview {{ $loop->iteration }}" class="card w-full object-cover">
            @empty
                <div class="card p-10 text-center text-slate-500">No previews uploaded.</div>
            @endforelse
        </section>

        <section>
            <div class="card p-6 md:p-7">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-900 md:text-4xl">{{ $product->title }}</h1>
                <p class="mt-4 text-slate-600">{{ $product->description }}</p>
                <p class="mt-6 text-4xl font-bold text-slate-900">${{ number_format($product->price_usd, 2) }}</p>

                @auth
                    <form action="{{ route('checkout.store', $product->slug) }}" method="POST" class="mt-6">
                        @csrf
                        <button class="btn-primary w-full">Buy Now</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-primary mt-6 w-full">Login to Buy</a>
                @endauth
            </div>

            <div class="mt-4 grid gap-4">
                <div class="card p-5 accent-mint">
                    <h2 class="text-lg font-semibold text-slate-900">What's Included</h2>
                    <ul class="mt-3 space-y-2 text-sm text-slate-700">
                        @forelse ($inclusions as $inclusion)
                            <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-slate-700"></span>{{ $inclusion }}</li>
                        @empty
                            <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-slate-700"></span>Digital source files</li>
                        @endforelse
                    </ul>
                </div>

                <div class="card p-5 accent-lilac">
                    <h2 class="text-lg font-semibold text-slate-900">File Formats</h2>
                    <p class="mt-2 text-sm text-slate-700">{{ $formats->isNotEmpty() ? $formats->implode(', ') : 'Formats appear after file upload.' }}</p>
                </div>

                <div class="card p-5 accent-peach">
                    <h2 class="text-lg font-semibold text-slate-900">License</h2>
                    <p class="mt-2 text-sm text-slate-700">{{ config('store.license_summary') }}</p>
                    <a href="{{ route('license') }}" class="mt-3 inline-flex text-sm font-medium text-slate-900 underline">Read full license</a>
                </div>
            </div>
        </section>
    </div>
</x-layouts.store>
