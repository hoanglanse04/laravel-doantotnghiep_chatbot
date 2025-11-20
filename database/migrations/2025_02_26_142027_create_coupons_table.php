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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Mã giảm giá');
            $table->decimal('discount_amount', 10, 2)->nullable()->comment('Số tiền giảm giá');
            $table->integer('discount_percentage')->nullable()->comment('Phần trăm giảm giá');
            $table->enum('discount_type', ['fixed', 'percentage'])->default('fixed')->comment('Loại giảm giá (cố định hoặc phần trăm)');
            $table->timestamp('valid_from')->nullable()->comment('Thời gian bắt đầu có hiệu lực');
            $table->timestamp('valid_to')->nullable()->comment('Thời gian kết thúc hiệu lực');
            $table->integer('usage_limit')->nullable()->comment('Giới hạn số lần sử dụng');
            $table->integer('used_count')->default(0)->comment('Số lần đã sử dụng');
            $table->boolean('status')->default(true)->comment('Trạng thái coupon (kích hoạt hoặc hủy)');
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
