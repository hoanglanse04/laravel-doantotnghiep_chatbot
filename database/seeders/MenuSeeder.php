<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Models\Menu;
use Modules\Admin\Models\MenuItem;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menu = Menu::create([
            'name' => 'Main Menu',
            'slug' => 'main-menu'
        ]);

        // Tạo menu items
        $home = MenuItem::create([
            'menu_id' => $menu->id,
            'name' => 'Home',
            'url' => '/',
            'icon' => 'home',
            'type' => 'link',
            'target' => '_self',
            'order' => 1,
            'parent_id' => 0
        ]);

        $about = MenuItem::create([
            'menu_id' => $menu->id,
            'name' => 'About Us',
            'url' => '/about',
            'icon' => 'info',
            'type' => 'link',
            'target' => '_self',
            'order' => 2,
            'parent_id' => 0
        ]);

        // Submenu
        MenuItem::create([
            'menu_id' => $menu->id,
            'name' => 'Our Team',
            'url' => '/about/team',
            'icon' => 'users',
            'type' => 'link',
            'target' => '_self',
            'order' => 1,
            'parent_id' => $about->id
        ]);
    }
}
