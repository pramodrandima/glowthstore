<x-layouts.store>
    <div class="mb-8">
        <h1 class="section-title">Shop Glowth Products</h1>
        <p class="muted mt-2 text-sm">Filter by category, tags, and sort by price or newest.</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-[280px_1fr]">
        <aside>
            <form method="GET" class="card space-y-3 p-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products" class="store-input">

                <select name="category" class="store-input">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>

                <select name="tag" class="store-input">
                    <option value="">All tags</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->slug }}" @selected(request('tag') === $tag->slug)>{{ $tag->name }}</option>
                    @endforeach
                </select>

                <select name="sort" class="store-input">
                    <option value="newest" @selected(request('sort') === 'newest')>Newest</option>
                    <option value="price_asc" @selected(request('sort') === 'price_asc')>Price low to high</option>
                    <option value="price_desc" @selected(request('sort') === 'price_desc')>Price high to low</option>
                </select>

                <button class="btn-primary w-full">Apply Filters</button>
            </form>
        </aside>

        <section>
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($products as $product)
                    @php
                        $preview = $product->previews->first();
                        $isUrl = $preview && str_starts_with($preview->image_path, 'http');
                    @endphp
                    <article class="product-card">
                        <a href="{{ route('product.show', $product->slug) }}">
                            @if ($preview)
                                <img src="{{ $isUrl ? $preview->image_path : Storage::disk('public')->url($preview->image_path) }}" class="h-52 w-full object-cover" alt="{{ $product->title }}">
                            @else
                                <div class="flex h-52 items-center justify-center bg-slate-100 text-slate-500">No preview</div>
                            @endif
                        </a>
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-slate-900"><a href="{{ route('product.show', $product->slug) }}">{{ $product->title }}</a></h3>
                            <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ $product->short_description }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <p class="text-xl font-bold text-slate-900">${{ number_format($product->price_usd, 2) }}</p>
                                <a href="{{ route('product.show', $product->slug) }}" class="btn-ghost px-3 py-2 text-xs">View</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="card p-6 text-slate-600">No products found for your filters.</div>
                @endforelse
            </div>

            <div class="mt-8">{{ $products->links() }}</div>
        </section>
    </div>
</x-layouts.store>
