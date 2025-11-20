<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Chuyên mục bài viết (Post)
            ['name' => 'Công nghệ', 'type' => 'post'],
            ['name' => 'Kinh doanh', 'type' => 'post'],
            ['name' => 'Giải trí', 'type' => 'post'],
            ['name' => 'Thể thao', 'type' => 'post'],
            ['name' => 'Du lịch', 'type' => 'post'],
            ['name' => 'Ẩm thực', 'type' => 'post'],
            ['name' => 'Giáo dục', 'type' => 'post'],
            ['name' => 'Sức khỏe', 'type' => 'post'],

            // Chuyên mục sản phẩm thời trang (Product)
            ['name' => 'Thời trang nam', 'type' => 'product'],
            ['name' => 'Thời trang nữ', 'type' => 'product'],
            ['name' => 'Giày dép', 'type' => 'product'],
            ['name' => 'Túi xách', 'type' => 'product'],
            ['name' => 'Phụ kiện thời trang', 'type' => 'product'],

            // Chuyên mục dự án bất động sản (Project)
            ['name' => 'Căn hộ chung cư', 'type' => 'project'],
            ['name' => 'Nhà phố', 'type' => 'project'],
            ['name' => 'Biệt thự', 'type' => 'project'],
            ['name' => 'Đất nền', 'type' => 'project'],
            ['name' => 'Shophouse', 'type' => 'project'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => 'Danh mục ' . strtolower($category['name']),
                'image' => '/assets/images/category-default.jpg',
                'content' => '<p>Thông tin về danh mục ' . $category['name'] . '.</p>',
                'meta_title' => $category['name'] . ' - Tin tức mới nhất',
                'meta_keywords' => strtolower($category['name']) . ', tin tức, cập nhật',
                'meta_description' => 'Tổng hợp tin tức mới nhất về ' . strtolower($category['name']) . '.',
                'status' => 'published',
                'type' => $category['type'],
                'user_id' => 1
            ]);
        }
    }
}
