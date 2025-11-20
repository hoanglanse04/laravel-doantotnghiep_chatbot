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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('ID người dùng tạo trang');
            $table->string('title')->comment('Tiêu đề trang');
            $table->string('slug')->unique()->comment('Slug của trang');
            $table->text('content')->nullable()->comment('Nội dung trang');
            $table->string('image')->nullable()->comment('Hình ảnh trang');
            $table->string('template')->nullable()->comment('Mẫu trang');
            $table->enum('status', ['draft', 'published'])->default('published')->comment('Trạng thái trang');
            $table->string('meta_title')->nullable()->comment('Tiêu đề meta cho SEO');
            $table->string('meta_keywords')->nullable()->comment('Từ khóa meta cho SEO');
            $table->text('meta_description')->nullable()->comment('Mô tả meta cho SEO');
            $table->timestamp('published_at')->nullable()->comment('Thời gian xuất bản trang');
            $table->softDeletes()->comment('Dữ liệu xóa mềm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
