<x-layouts.store>
    <div class="flex flex-col gap-8 lg:flex-row">
        <aside class="w-full lg:w-64">
            <form method="GET" class="space-y-4 rounded-xl border border-slate-200 bg-white p-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products" class="w-full rounded border-slate-300 text-sm">
                <select name="category" class="w-full rounded border-slate-300 text-sm">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="tag" class="w-full rounded border-slate-300 text-sm">
                    <option value="">All tags</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->slug }}" @selected(request('tag') === $tag->slug)>{{ $tag->name }}</option>
                    @endforeach
                </select>
                <select name="sort" class="w-full rounded border-slate-300 text-sm">
                    <option value="newest" @selected(request('sort') === 'newest')>Newest</option>
                    <option value="price_asc" @selected(request('sort') === 'price_asc')>Price low to high</option>
                    <option value="price_desc" @selected(request('sort') === 'price_desc')>Price high to low</option>
                </select>
                <button class="w-full rounded bg-sky-600 px-4 py-2 text-sm font-medium text-white">Apply</button>
            </form>
        </aside>

        <section class="flex-1">
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($products as $product)
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
                            <h3 class="font-semibold"><a href="{{ route('product.show', $product->slug) }}">{{ $product->title }}</a></h3>
                            <p class="mt-1 text-sm text-slate-600">{{ $product->short_description }}</p>
                            <p class="mt-3 text-lg font-bold">${{ number_format($product->price_usd, 2) }}</p>
                        </div>
                    </article>
                @empty
                    <p class="text-slate-600">No products found.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </section>
    </div>
</x-layouts.store>
