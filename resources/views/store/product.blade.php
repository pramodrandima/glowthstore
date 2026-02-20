<x-layouts.store>
    @php
        $inclusions = $product->inclusions ?? [];
    @endphp
    <div class="grid gap-8 lg:grid-cols-2">
        <section>
            <div class="space-y-4">
                @forelse ($product->previews as $preview)
                    @php($isUrl = str_starts_with($preview->image_path, 'http'))
                    <img src="{{ $isUrl ? $preview->image_path : Storage::disk('public')->url($preview->image_path) }}" alt="Preview {{ $loop->iteration }}" class="w-full rounded-xl border border-slate-200 object-cover">
                @empty
                    <div class="rounded-xl border border-slate-200 bg-slate-100 p-10 text-center text-slate-500">No previews uploaded.</div>
                @endforelse
            </div>
        </section>

        <section>
            <p class="text-sm uppercase text-slate-500">{{ $product->category?->name ?? 'Uncategorized' }}</p>
            <h1 class="mt-1 text-3xl font-bold">{{ $product->title }}</h1>
            <p class="mt-4 text-slate-700">{{ $product->description }}</p>
            <p class="mt-6 text-3xl font-bold">${{ number_format($product->price_usd, 2) }}</p>

            @auth
                <form action="{{ route('checkout.store', $product->slug) }}" method="POST" class="mt-6">
                    @csrf
                    <button class="w-full rounded bg-sky-600 px-6 py-3 font-semibold text-white">Buy now</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mt-6 inline-flex w-full justify-center rounded bg-slate-900 px-6 py-3 font-semibold text-white">Login to buy</a>
            @endauth

            <div class="mt-8 rounded-xl border border-slate-200 bg-white p-5">
                <h2 class="text-lg font-semibold">What's included</h2>
                <ul class="mt-3 list-inside list-disc text-sm text-slate-700">
                    @forelse ($inclusions as $inclusion)
                        <li>{{ $inclusion }}</li>
                    @empty
                        <li>Digital source files</li>
                    @endforelse
                </ul>
            </div>

            <div class="mt-4 rounded-xl border border-slate-200 bg-white p-5">
                <h2 class="text-lg font-semibold">File formats</h2>
                <p class="mt-2 text-sm text-slate-700">{{ $formats->isNotEmpty() ? $formats->implode(', ') : 'Formats appear after file upload.' }}</p>
            </div>

            <div class="mt-4 rounded-xl border border-slate-200 bg-white p-5 text-sm text-slate-700">
                <h2 class="text-lg font-semibold text-slate-900">License</h2>
                <p class="mt-2">{{ config('store.license_summary') }}</p>
                <a href="{{ route('license') }}" class="mt-2 inline-block text-sky-600">Read full license</a>
            </div>
        </section>
    </div>
</x-layouts.store>
