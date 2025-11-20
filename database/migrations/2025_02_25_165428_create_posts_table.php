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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('ID người dùng tạo bài viết');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade')->comment('ID danh mục bài viết');
            $table->string('title')->comment('Tiêu đề bài viết');
            $table->string('slug')->unique()->comment('Slug của bài viết');
            $table->text('content')->nullable()->comment('Nội dung bài viết');
            $table->string('image')->nullable()->comment('Hình ảnh bài viết');
            $table->enum('status', ['draft', 'published'])->default('draft')->comment('Trạng thái bài viết');
            $table->string('meta_title')->nullable()->comment('Tiêu đề meta cho SEO');
            $table->string('meta_keywords')->nullable()->comment('Từ khóa meta cho SEO');
            $table->text('meta_description')->nullable()->comment('Mô tả meta cho SEO');
            $table->timestamp('published_at')->nullable()->comment('Thời gian xuất bản bài viết');
            $table->softDeletes()->comment('Dữ liệu xóa mềm');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
