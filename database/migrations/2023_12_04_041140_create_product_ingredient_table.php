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
        Schema::create('product_ingredient', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('product_id');
			$table->unsignedBigInteger('ingredient_id');
			$table->timestamps();

			$table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
			$table->foreign('ingredient_id')->references('id')->on('ingredient')->onDelete('cascade');
		});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ingredient');
    }
};
