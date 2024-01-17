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
            $table->string('name', 150)->nullable();
            $table->double('price')->nullable();
            $table->double('discount')->nullable();
            $table->longText('description')->nullable();
            $table->string('type', 50)->nullable();
            $table->string('external_code', 50)->nullable();
            $table->string('barcode', 50)->nullable();
            $table->string('seller', 50)->nullable();
            $table->timestamps();
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
