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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã giảm giá
            $table->enum('type', ['percent', 'fixed']); // Loại: % hay số tiền cố định
            $table->decimal('value', 10, 2); // Giá trị (ví dụ 10% hoặc 50000 VNĐ)
            $table->decimal('min_order_value', 10, 2)->nullable(); // Đơn hàng tối thiểu
            $table->integer('usage_limit')->nullable(); // Số lần sử dụng tối đa
            $table->integer('used_count')->default(0); // Đã sử dụng bao nhiêu lần
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
