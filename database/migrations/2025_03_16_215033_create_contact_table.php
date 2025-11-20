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
        Schema::create('contact', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Tên người liên hệ');
            $table->string('phone')->nullable()->comment('Số điện thoại người liên hệ');
            $table->string('email')->nullable()->comment('Email người liên hệ');
            $table->string('address')->nullable()->comment('Địa chỉ người liên hệ');
            $table->text('content')->nullable()->comment('Nội dung liên hệ');
            $table->string('url')->nullable()->comment('URL liên kết đến trang liên hệ');
            $table->string('status')->nullable()->comment('Trạng thái liên hệ (chờ phản hồi, đã xử lý, v.v.)');
            $table->softDeletes()->comment('Dữ liệu xóa mềm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact');
    }
};
