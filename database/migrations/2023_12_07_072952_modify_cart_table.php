<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            // Các sửa đổi khác nếu cần thiết
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
	{
		Schema::table('cart', function (Blueprint $table) {
			// Xóa thuộc tính 'nullable' của trường 'user_id'
			$table->unsignedBigInteger('user_id')->change();
		});
	}
};
