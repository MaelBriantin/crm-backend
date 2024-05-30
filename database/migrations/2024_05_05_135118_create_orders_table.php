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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('sector_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('payment_method');
            $table->float('vat_total');
            $table->float('no_vat_total');
            $table->date('order_date');
            $table->date('deferred_date')->nullable();
            $table->boolean('is_paid')->default(true);
            $table->string('customer_full_name');
            $table->string('customer_address');
            $table->string('customer_city');
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('customer_id');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
