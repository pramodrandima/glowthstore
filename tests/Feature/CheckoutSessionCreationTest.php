<?php

namespace Tests\Feature;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\Stripe\StripeCheckoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Stripe\Checkout\Session;
use Tests\TestCase;

class CheckoutSessionCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_endpoint_creates_session_and_redirects(): void
    {
        URL::forceRootUrl('http://localhost');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::query()->create(['name' => 'Branding', 'slug' => 'branding']);

        $product = Product::query()->create([
            'owner_type' => 'glowth',
            'title' => 'Checkout Product',
            'slug' => 'checkout-product',
            'status' => ProductStatus::PUBLISHED,
            'price_usd' => 19.00,
            'category_id' => $category->id,
        ]);

        $mock = \Mockery::mock(StripeCheckoutService::class);
        $mock->shouldReceive('createSession')->once()->andReturn(Session::constructFrom([
            'id' => 'cs_test_123',
            'url' => 'https://checkout.stripe.com/pay/cs_test_123',
        ]));
        $this->app->instance(StripeCheckoutService::class, $mock);

        $response = $this->actingAs($user)->post(route('checkout.store', $product->slug));

        $response->assertRedirect('https://checkout.stripe.com/pay/cs_test_123');
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('payments', ['stripe_checkout_session_id' => 'cs_test_123']);

        $order = Order::query()->first();
        $this->assertEquals($user->id, $order->user_id);
    }
}
