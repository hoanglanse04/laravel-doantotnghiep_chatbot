<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->nullable()->constrained()->onDelete('cascade')->comment('ID menu mà mục này thuộc về');
            $table->string('name')->comment('Tên của mục menu');
            $table->string('url')->nullable()->comment('URL liên kết của mục menu');
            $table->text('icon')->nullable()->comment('Icon của mục menu');
            $table->string('type')->nullable()->comment('Loại mục menu');
            $table->enum('status', ['draft', 'published'])->default('published')->comment('Trạng thái của mục menu');
            $table->string('target')->default('_self')->comment('Mở liên kết trong tab hiện tại hoặc tab mới');
            $table->unsignedBigInteger('parent_id')->default(0)->comment('ID của mục cha nếu có');
            $table->integer('order')->default(0)->comment('Thứ tự của mục menu');
            $table->string('image')->nullable()->comment('Hình ảnh đại diện cho mục menu');
            $table->json('custom_fields')->nullable()->comment('Các trường tùy chỉnh cho mục menu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
