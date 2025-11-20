<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('ID người dùng tạo sản phẩm');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade')->comment('ID danh mục sản phẩm');
            $table->string('name')->comment('Tên sản phẩm');
            $table->string('slug')->unique()->comment('Slug của sản phẩm');
            $table->string('sku')->nullable()->comment('Mã sản phẩm (SKU)');
            $table->longText('content')->nullable()->comment('Nội dung chi tiết sản phẩm');
            $table->text('description')->nullable()->comment('Mô tả ngắn về sản phẩm');
            $table->unsignedBigInteger('price')->default(0)->comment('Giá bán');
            $table->unsignedBigInteger('discount_price')->default(0)->comment('Giá sau giảm');
            $table->unsignedBigInteger('discount_percentage')->default(0)->comment('Phần trăm giảm');
            $table->unsignedBigInteger('final_price')->default(0)->comment('Giá cuối cùng sau giảm');
            $table->integer('stock')->default(0)->comment('Số lượng tồn kho');
            $table->string('image')->nullable()->comment('Hình ảnh đại diện sản phẩm');
            $table->json('multiple_image')->nullable()->comment('Hình ảnh phụ sản phẩm');
            $table->json('specifications')->nullable()->comment('Thông số kỹ thuật');
            $table->enum('status', ['draft', 'published'])->default('published')->comment('Trạng thái sản phẩm');
            $table->timestamp('published_at')->nullable()->comment('Thời gian xuất bản sản phẩm');
            $table->string('meta_title')->nullable()->comment('Tiêu đề meta cho SEO');
            $table->string('meta_keywords')->nullable()->comment('Từ khóa meta cho SEO');
            $table->text('meta_description')->nullable()->comment('Mô tả meta cho SEO');
            $table->softDeletes()->comment('Dữ liệu xóa mềm');
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
