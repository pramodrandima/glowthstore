<?php

namespace Database\Seeders;

use App\Enums\ProductStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class GlowthStoreSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@glowthstore.test'],
            [
                'name' => 'Glowth Admin',
                'role' => UserRole::ADMIN,
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        $category = Category::query()->firstOrCreate(
            ['slug' => 'branding'],
            ['name' => 'Branding Kits']
        );

        $tag1 = Tag::query()->firstOrCreate(['slug' => 'minimal'], ['name' => 'Minimal']);
        $tag2 = Tag::query()->firstOrCreate(['slug' => 'social-media'], ['name' => 'Social Media']);

        $disk = config('store.product_files_disk');
        Storage::disk($disk)->put('samples/glowth-brand-kit.zip', 'Sample Glowth Brand Kit');
        Storage::disk($disk)->put('samples/launch-pack.zip', 'Sample Product Launch Pack');

        $products = [
            [
                'title' => 'Glowth Brand Kit Essentials',
                'slug' => 'glowth-brand-kit-essentials',
                'short_description' => 'Logos, color tokens, and starter assets for quick launch.',
                'description' => 'A practical branding starter with layered source files and web-ready exports.',
                'price_usd' => 39,
                'inclusions' => ['Primary logo files', 'Color palette', 'Typography guide', 'Social templates'],
                'preview' => 'https://picsum.photos/seed/glowth-1/1200/800',
                'file_path' => 'samples/glowth-brand-kit.zip',
                'display_name' => 'Glowth-Brand-Kit.zip',
                'format' => 'ZIP',
            ],
            [
                'title' => 'Glowth Product Launch Pack',
                'slug' => 'glowth-product-launch-pack',
                'short_description' => 'Campaign-ready visuals for product launch day.',
                'description' => 'Editable PSD/AI source set for product launch promotions and hero creatives.',
                'price_usd' => 49,
                'inclusions' => ['Launch hero banners', 'Ad creative variants', 'Email header assets'],
                'preview' => 'https://picsum.photos/seed/glowth-2/1200/800',
                'file_path' => 'samples/launch-pack.zip',
                'display_name' => 'Glowth-Launch-Pack.zip',
                'format' => 'ZIP',
            ],
        ];

        foreach ($products as $index => $data) {
            $product = Product::query()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'owner_type' => 'glowth',
                    'owner_id' => null,
                    'category_id' => $category->id,
                    'title' => $data['title'],
                    'status' => ProductStatus::PUBLISHED,
                    'price_usd' => $data['price_usd'],
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'inclusions' => $data['inclusions'],
                    'featured' => $index === 0,
                ]
            );

            $product->tags()->syncWithoutDetaching([$tag1->id, $tag2->id]);

            $product->previews()->updateOrCreate(
                ['sort_order' => 0],
                ['image_path' => $data['preview']]
            );

            $size = Storage::disk($disk)->size($data['file_path']);

            $product->files()->updateOrCreate(
                ['storage_path' => $data['file_path']],
                [
                    'storage_disk' => $disk,
                    'display_name' => $data['display_name'],
                    'format' => $data['format'],
                    'file_size' => $size,
                ]
            );
        }
    }
}
