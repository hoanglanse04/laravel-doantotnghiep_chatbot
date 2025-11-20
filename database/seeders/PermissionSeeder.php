<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1. Tạo các vai trò
        $roles = [
            ['name' => 'super-admin', 'description' => 'Quản trị hệ thống', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'admin', 'description' => 'Quản trị viên', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'editor', 'description' => 'Người viết bài', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'moderator', 'description' => 'Người kiểm duyệt', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('roles')->insert($roles);

        // 2. Tạo danh sách modules
        $modules = [
            'overview' => 'Bảng điều khiển',
            'product' => 'Sản phẩm',
            'post' => 'Bài viết',
            'project' => 'Dự án',
            'setting' => 'Cài đặt',
            'builder' => 'Builder',
            'dashboard' => 'Tổng quan',
            'page' => 'Trang đơn',
            'contact' => 'Liên hệ',
            'user' => 'Người dùng',
            'roles' => 'Vai trò & Quyền',
            'category' => 'Chuyên mục'
        ];

        // 3. Tạo permission mặc định cho mỗi module
        $actions = [
            'viewAny' => 'Danh sách',
            'create' => 'Tạo mới',
            'view' => 'Xem trước',
            'update' => 'Chỉnh sửa',
            'delete' => 'Xoá',
        ];

        $permissions = [];
        $pivot = [];

        $i = 1;
        foreach ($modules as $module => $moduleName) {
            foreach ($actions as $key => $actionName) {
                $permissions[] = [
                    'id' => $i,
                    'key' => "$key-$module",
                    'name' => "$actionName $moduleName",
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Gán tất cả quyền cho super-admin
                $pivot[] = [
                    'permission_id' => $i,
                    'role_id' => 1 // Super Admin
                ];

                // Gán quyền tùy theo role
                if (in_array($key, ['viewAny', 'view'])) {
                    $pivot[] = ['permission_id' => $i, 'role_id' => 2]; // admin
                    $pivot[] = ['permission_id' => $i, 'role_id' => 3]; // editor
                    $pivot[] = ['permission_id' => $i, 'role_id' => 4]; // moderator
                }

                if (in_array($key, ['create', 'update'])) {
                    $pivot[] = ['permission_id' => $i, 'role_id' => 2]; // admin
                    $pivot[] = ['permission_id' => $i, 'role_id' => 3]; // editor
                }

                if ($key === 'delete') {
                    $pivot[] = ['permission_id' => $i, 'role_id' => 2]; // admin
                    $pivot[] = ['permission_id' => $i, 'role_id' => 4]; // moderator
                }

                $i++;
            }
        }

        // 4. Insert permissions và permission_role
        DB::table('permissions')->insert($permissions);
        DB::table('permission_role')->insert($pivot);

        // 5. Gán user mẫu
        DB::table('role_user')->insert([
            ['role_id' => 1, 'user_id' => 1],
            ['role_id' => 2, 'user_id' => 2],
            ['role_id' => 3, 'user_id' => 3],
            ['role_id' => 4, 'user_id' => 4],
        ]);
    }
}
