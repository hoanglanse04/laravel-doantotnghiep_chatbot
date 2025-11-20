<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Tạo người dùng chính nếu chưa có
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('superadmin123'),
                'email_verified_at' => $now,
                'image' => null,
                'status' => 'active',
                'gender' => 'male',
                'role' => 'superadmin',
                'code' => 'SUPER001',
                'phone' => '0900000002',
                'description' => 'Tài khoản cao nhất hệ thống',
                'tags' => json_encode(['superadmin', 'root']),
                'wallet_id' => null,
                'website' => 'https://superadmin.local',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'email_verified_at' => $now,
                'image' => null,
                'status' => 'active',
                'gender' => 'male',
                'role' => 'admin',
                'code' => 'ADMIN001',
                'phone' => '0900000001',
                'description' => 'Tài khoản quản trị viên',
                'tags' => json_encode(['admin', 'root']),
                'wallet_id' => null,
                'website' => 'https://admin.local',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Editor',
                'email' => 'editor@gmail.com',
                'password' => bcrypt('editor123'),
                'email_verified_at' => $now,
                'image' => null,
                'status' => 'active',
                'gender' => 'female',
                'role' => 'editor',
                'code' => 'EDITOR001',
                'phone' => '0900000003',
                'description' => 'Tài khoản người viết bài',
                'tags' => json_encode(['editor']),
                'wallet_id' => null,
                'website' => 'https://editor.local',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Moderator',
                'email' => 'moderator@gmail.com',
                'password' => bcrypt('moderator123'),
                'email_verified_at' => $now,
                'image' => null,
                'status' => 'active',
                'gender' => 'female',
                'role' => 'moderator',
                'code' => 'MOD001',
                'phone' => '0900000004',
                'description' => 'Tài khoản kiểm duyệt nội dung',
                'tags' => json_encode(['moderator']),
                'wallet_id' => null,
                'website' => 'https://moderator.local',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Gán role theo role.name
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                DB::table('role_user')->updateOrInsert([
                    'user_id' => $user->id,
                    'role_id' => $role->id,
                ], [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
