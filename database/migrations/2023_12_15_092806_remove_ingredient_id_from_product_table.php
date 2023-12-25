<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('ingredient_id');
        });
    }

    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->unsignedBigInteger('ingredient_id');

            $table->foreign('ingredient_id')
                ->references('id')
                ->on('ingredient')
                ->onDelete('cascade');
        });
    }
};