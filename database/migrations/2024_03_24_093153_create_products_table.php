<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('reference')->nullable()->unique();
            $table->unsignedBigInteger('brand_id');
            $table->decimal('purchase_price')->nullable();
            $table->decimal('selling_price')->nullable();
            $table->decimal('selling_price_with_vat')->nullable();
            $table->decimal('vat_rate')->default(\App\Enums\Product\VatRate::TWENTY);
            $table->string('product_type')->default(\App\Enums\Product\ProductType::DEFAULT);
            $table->integer('measurement_quantity')->nullable();
            $table->string('measurement_unit')->nullable();
            $table->unsignedBigInteger('stock')->default(0);
            $table->unsignedBigInteger('alert_stock')->default(0);
            $table->string('image')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
