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
        Schema::create('movement_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stock_movement_id')->constrained('stock_movements')->restrictOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();

            $table->foreignId('lot_id')->constrained('lots')->restrictOnDelete();

            $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();

            $table->integer('quantity')->default(1)->check('quantity > 0');
            $table->decimal('price', 10, 2)->nullable()->check('price >= 0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_items');
    }
};
