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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id()->comment('ID của mối quan hệ giữa người dùng và vai trò');
            $table->unsignedBigInteger(column: 'role_id')->comment('ID vai trò của người dùng');
            $table->unsignedBigInteger('user_id')->comment('ID người dùng');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->comment('Khóa ngoại liên kết đến bảng roles, xóa khi vai trò bị xóa');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->comment('Khóa ngoại liên kết đến bảng users, xóa khi người dùng bị xóa');
            $table->unique(['role_id', 'user_id'])->comment('Mối quan hệ một vai trò cho một người dùng');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
