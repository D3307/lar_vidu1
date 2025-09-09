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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Tên giày
        $table->text('description')->nullable(); // Mô tả
        $table->integer('quantity'); // Số lượng
        $table->decimal('price', 10, 2); // Giá
        $table->string('color')->nullable(); // Màu sắc
        $table->string('size')->nullable(); // Kích cỡ
        $table->string('material')->nullable(); // Chất liệu
        $table->string('image')->nullable(); // Ảnh sản phẩm
        $table->unsignedBigInteger('category_id'); // Khóa phụ đến categories
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
