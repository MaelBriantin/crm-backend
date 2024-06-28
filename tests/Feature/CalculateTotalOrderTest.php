<?php

namespace Tests\Feature;

use function Pest\Laravel\{post, actingAs};
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
    $this->user = $user;
});

test('calculate total order', function () {
    $brand = Brand::factory()->create();

    $price1 = 20;
    $price2 = 10;

    $product1 = [
        'name' => 'test',
        'description' => '',
        'reference' => 'ref000',
        'brand_id' => $brand->id,
        'purchase_price' => $price1,
        'selling_price' => $price1,
        'selling_price_with_vat' => $price1 * 1.2,
        'vat_rate' => '20',
        'product_type' => 'default',
        'measurement_quantity' => 250,
        'measurement_unit' => 'g',
        'stock' => 10,
        'alert_stock' => 0,
        'image' => null,
        'user_id' => $this->user->id
    ];

    $product2 = [
        'name' => 'test',
        'description' => '',
        'reference' => 'ref001',
        'brand_id' => $brand->id,
        'purchase_price' => $price2,
        'selling_price' => $price2,
        'selling_price_with_vat' => $price2 * 1.2,
        'vat_rate' => '20',
        'product_type' => 'default',
        'measurement_quantity' => 250,
        'measurement_unit' => 'g',
        'stock' => 10,
        'alert_stock' => 0,
        'image' => null,
        'user_id' => $this->user->id
    ];

    post('/api/products', $product1);
    post('/api/products', $product2);

    $product1 = Product::where('reference', 'ref000')->first();
    $product2 = Product::where('reference', 'ref001')->first();

    $orderedProducts = [
        [
            'product_id' => $product1->id,
            'ordered_quantity' => 2,
        ],
        [
            'product_id' => $product2->id,
            'ordered_quantity' => 4,
        ],
    ];

    $resultsMustBe = [
        'vat_total' => 96,
        'no_vat_total' => 80
    ];

    $orderService = new OrderService();
    $result = $orderService->calculateTotal($orderedProducts);

    expect($result['vat_total'])->toBe($resultsMustBe['vat_total']);
});
