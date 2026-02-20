<?php

namespace Tests\Feature;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_page_loads_for_published_product(): void
    {
        $category = Category::query()->create(['name' => 'Branding', 'slug' => 'branding']);

        $product = Product::query()->create([
            'owner_type' => 'glowth',
            'title' => 'Test Product',
            'slug' => 'test-product',
            'status' => ProductStatus::PUBLISHED,
            'price_usd' => 29.00,
            'category_id' => $category->id,
        ]);

        $response = $this->get(route('product.show', $product->slug));

        $response->assertOk();
        $response->assertSee('Test Product');
    }
}
