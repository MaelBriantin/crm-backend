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
            $table->string('reference')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->decimal('purchase_price')->nullable();
            $table->decimal('sale_price')->nullable();
            $table->unsignedBigInteger('vat_rate_id')->default(1);
            $table->string('product_type')->default('default');
            $table->integer('measure_quantity')->nullable();
            $table->foreignId('measure_unit_id')->nullable();
            $table->unsignedBigInteger('stock')->default(0);
            $table->string('image')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('vat_rate_id')->references('id')->on('vat_rates')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('measure_unit_id')->references('id')->on('measure_units')->onUpdate('cascade')->onDelete('set null');
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
