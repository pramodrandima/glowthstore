<?php

use App\Enums\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('owner_type')->default('glowth');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('status')->default(ProductStatus::DRAFT->value)->index();
            $table->decimal('price_usd', 10, 2);
            $table->boolean('featured')->default(false)->index();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->json('inclusions')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['owner_type', 'owner_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
