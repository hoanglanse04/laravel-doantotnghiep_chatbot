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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('ID người dùng tạo danh mục');
            $table->string('name')->comment('Tên danh mục');
            $table->string('slug')->unique()->comment('Đường dẫn thân thiện của danh mục');
            $table->text('description')->nullable()->comment('Mô tả ngắn về danh mục');
            $table->text('image')->nullable()->comment('Ảnh đại diện của danh mục');
            $table->longText('content')->nullable()->comment('Nội dung chi tiết của danh mục');
            $table->string('meta_title')->nullable()->comment('Tiêu đề meta cho SEO');
            $table->string('meta_keywords')->nullable()->comment('Từ khóa meta cho SEO');
            $table->text('meta_description')->nullable()->comment('Mô tả meta cho SEO');
            $table->enum('status', ['draft', 'published'])->default('draft')->comment('Trạng thái của danh mục');
            $table->enum('type', ['post', 'product', 'project'])->default('product')->comment('Loại danh mục');
            $table->softDeletes()->comment('Dữ liệu xóa mềm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
