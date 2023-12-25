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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
			$table->integer('quantity');
			$table->decimal('price', 8, 2);
			$table->unsignedBigInteger('user_id')->nullable()->default(null);
			$table->unsignedBigInteger('product_id');
			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('product_id')->references('id')->on('product');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
