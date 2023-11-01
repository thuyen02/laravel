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
            $table->string('product_code');
            $table->string('product_name');
            $table->foreignId('category_id')->constrained('category')->onDelete('cascade');
            $table->integer('status')->default(1);
            $table->foreignId('unit_id')->constrained('unit')->onDelete('cascade');
            $table->double('price',10,2);
            $table->double('price_retail',10,2);
            $table->double('price_wholesale',10,2);
            $table->string('image')->nullable();
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
