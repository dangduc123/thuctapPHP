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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->decimal('price', 8, 2);
            $table->string('image');
            $table->text('description');
            $table->string('product_type');
            $table->string('status')->default('active')->nullable();
            $table->unsignedBigInteger('ingredient_id');

            $table->foreign('ingredient_id')
                ->references('id')
                ->on('ingredient')
                ->onDelete('cascade'); // Optional: Add onDelete('cascade') if you want to automatically delete related products when the ingredient is deleted

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
