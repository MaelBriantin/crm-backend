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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('postcode', 5);
            $table->string('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('visit_frequency_id')->nullable();
            $table->enum('visit_day', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])->nullable();
            $table->string('visit_schedule')->nullable();
            $table->unsignedBigInteger('relationship_id')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('visit_frequency_id')->references('id')->on('visit_frequencies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('relationship_id')->references('id')->on('relationships')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('sector_id')->references('id')->on('sectors')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();

            $table->index('is_active');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
