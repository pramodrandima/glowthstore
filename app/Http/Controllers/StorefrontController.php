<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function home(): View
    {
        $featuredProducts = Product::query()
            ->published()
            ->with(['category', 'previews'])
            ->where('featured', true)
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::query()->orderBy('name')->get();

        return view('store.home', compact('featuredProducts', 'categories'));
    }

    public function shop(Request $request): View
    {
        $query = Product::query()
            ->published()
            ->with(['category', 'previews', 'tags']);

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($category = $request->string('category')->toString()) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        if ($tag = $request->string('tag')->toString()) {
            $query->whereHas('tags', fn ($q) => $q->where('slug', $tag));
        }

        match ($request->string('sort')->toString()) {
            'price_asc' => $query->orderBy('price_usd'),
            'price_desc' => $query->orderByDesc('price_usd'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        return view('store.shop', [
            'products' => $products,
            'categories' => Category::query()->orderBy('name')->get(),
            'tags' => Tag::query()->orderBy('name')->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $product = Product::query()
            ->published()
            ->with(['category', 'previews', 'tags', 'files'])
            ->where('slug', $slug)
            ->firstOrFail();

        $formats = $product->files
            ->pluck('format')
            ->filter()
            ->unique()
            ->values();

        return view('store.product', compact('product', 'formats'));
    }
}
