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
        Schema::table('product', function (Blueprint $table) {
            // Xóa ràng buộc khóa ngoại
            $table->dropForeign(['ingredient_id']);
            // Xóa cột
            $table->dropColumn('ingredient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            // Thêm lại cột và khóa ngoại
            $table->unsignedBigInteger('ingredient_id')->after('status');
            $table->foreign('ingredient_id')
                ->references('id')
                ->on('ingredient')
                ->onDelete('cascade');
        });
    }
};
