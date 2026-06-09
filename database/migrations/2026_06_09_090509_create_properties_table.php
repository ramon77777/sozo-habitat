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
        Schema::create('properties', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->decimal('price', 15, 2);

            $table->string('city');

            $table->string('district')->nullable();

            $table->integer('surface')->nullable();

            $table->integer('bedrooms')->nullable();

            $table->integer('bathrooms')->nullable();

            $table->enum('type', [
                'maison',
                'appartement',
                'terrain',
                'bureau'
            ]);

            $table->enum('transaction', [
                'vente',
                'location'
            ]);

            $table->text('description')->nullable();

            $table->string('main_image')->nullable();

            $table->boolean('featured')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
