<?php

namespace Tests\Feature;

use App\Enums\Product\ProductType;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;

use function Pest\Laravel\{post, actingAs};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
    $this->user = $user;
});

test('can create default type product', function () {
    $brand = Brand::factory()->create();
    $price = 23;

    $product = [
        'name' => 'test',
        'description' => '',
        'reference' => 'ref000',
        'brand_id' => $brand->id,
        'purchase_price' => $price,
        'selling_price' => $price * 1.2,
        'selling_price_with_vat' => $price * 1.2,
        'vat_rate' => '20',
        'product_type' => ProductType::DEFAULT,
        'measurement_quantity' => 250,
        'measurement_unit' => 'g',
        'stock' => 10,
        'alert_stock' => 0,
        'image' => null,
    ];
    $response = post('/api/products', $product);
    $response->assertStatus(201);
    expect(Product::where('reference', 'ref000')->exists())->toBeTrue();
});

test('can create clothes type product and associated product_sizes', function () {
    $brand = Brand::factory()->create();
    $price = 23;
    $product = [
        'name' => 'test',
        'description' => '',
        'reference' => 'ref000',
        'brand_id' => $brand->id,
        'purchase_price' => $price,
        'selling_price' => $price * 1.2,
        'selling_price_with_vat' => $price * 1.2,
        'vat_rate' => '20',
        'product_type' => ProductType::CLOTHES,
        'measurement_quantity' => 250,
        'measurement_unit' => 'g',
        'stock' => 10,
        'alert_stock' => 0,
        'image' => null,
        'product_sizes' => [
            [
                'size' => 'S',
                'stock' => 10
            ]
        ]
    ];
    $response = post('/api/products', $product);
    $response->assertStatus(201);
    expect(Product::where('reference', 'ref000')->exists())->toBeTrue();
    $product = Product::where('reference', 'ref000')->first();
    expect(ProductSize::where('product_id', $product->id)->first()->size)->toBe('S');
});
