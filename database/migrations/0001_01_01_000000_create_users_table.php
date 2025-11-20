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
        Schema::create('wallets', function (Blueprint $table): void {
            $table->id();
            $table->decimal('amount', 15, 2)->default(0)->comment('Số dư chính');
            $table->decimal('promotional_amount', 15, 2)->default(0)->comment('Số dư khuyến mãi');
            $table->decimal('referral_amount', 15, 2)->default(0)->comment('Số dư giới thiệu');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên người dùng');
            $table->string('description')->nullable()->comment('Mô tả người dùng');
            $table->string('phone')->nullable()->comment('Số điện thoại');
            $table->string('code')->nullable()->comment('Mã khách hàng');
            $table->string('website')->nullable()->comment('Website');
            $table->string('email')->unique()->comment('Email người dùng');
            $table->timestamp('email_verified_at')->nullable()->comment('Thời gian xác thực email');
            $table->string('password')->comment('Mật khẩu');
            $table->string('image')->nullable()->comment('Ảnh đại diện');
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active')->comment('Trạng thái người dùng');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->comment('Giới tính');
            $table->string('role')->default('user')->comment('Vai trò người dùng');
            $table->json('tags')->nullable()->comment('Tags của người dùng');
            $table->foreignId('wallet_id')->nullable()->constrained('wallets')->nullOnDelete()->comment('Ví của người dùng');
            $table->rememberToken()->comment('Token nhớ người dùng');
            $table->softDeletes()->comment('Thời gian xoá mềm');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary()->comment('Email để reset mật khẩu');
            $table->string('token')->comment('Mã token reset mật khẩu');
            $table->timestamp('created_at')->nullable()->comment('Thời gian tạo token');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary()->comment('ID phiên làm việc');
            $table->foreignId('user_id')->nullable()->index()->comment('ID người dùng');
            $table->string('ip_address', 45)->nullable()->comment('Địa chỉ IP');
            $table->text('user_agent')->nullable()->comment('Thông tin về thiết bị người dùng');
            $table->longText('payload')->comment('Dữ liệu phiên làm việc');
            $table->integer('last_activity')->index()->comment('Thời gian hoạt động cuối cùng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
