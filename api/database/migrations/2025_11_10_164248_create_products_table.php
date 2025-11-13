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
            $table->string('name', 85);
            $table->string('code', 20)->unique();
            $table->integer('min_quantity')->check('min_quantity >= 0');
            $table->boolean('perishable')->default(true);
            $table->json('nutrition_facts')->nullable();

            //chaves estrangeiras que Impedem apagar o pai se existirem filhos
            $table->foreignId('unit_id')->constrained('measurement_units')->restrictOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('brand_id')->constrained('brands')->restrictOnDelete();

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
