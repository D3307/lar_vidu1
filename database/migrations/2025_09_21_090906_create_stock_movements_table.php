<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id');
            $table->enum('type', ['import', 'export', 'adjustment']); // nhập, xuất, điều chỉnh
            $table->integer('quantity');
            $table->string('note')->nullable(); // ghi chú thêm
            $table->timestamps();

            $table->foreign('inventory_id')
                  ->references('id')->on('inventories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};