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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->string('logradouro', 45)->nullable();
            $table->integer('number')->nullable()->check('number >= 0');
            $table->string('complemento', 100)->nullable();

            $table->foreignId('city_id')->constrained('cities')->restrictOnDelete();

            $table->string('bairro', 65)->nullable();
            $table->string('cep', 8)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adresses');
    }
};
