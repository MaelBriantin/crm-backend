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
        Schema::create('postcodes', function (Blueprint $table) {
            $table->id();
            $table->string('postcode', 5)->unique();
            $table->string('city');
            $table->unsignedBigInteger('sector_id');
            $table->timestamps();

            $table->foreign('sector_id')->references('id')->on('sectors')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postcodes');
    }
};
