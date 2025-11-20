<?php

use App\Enums\Common;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

use Modules\Admin\Models\MenuItem;
use Modules\Admin\Models\Menu;
use Modules\Admin\Models\SettingField;


if (!function_exists('setting')) {
    /**
     * Lấy giá trị từ bảng `settings`
     *
     * @param string $slug Tên của setting cần lấy
     * @param mixed $default Giá trị mặc định nếu không tìm thấy
     * @return mixed
     */
    function setting($slug, $default = ''): mixed
    {
        $settings = Cache::remember('settings', Carbon::now()->addDays(30), function (): array {
            return SettingField::pluck('value', 'slug')->toArray();
        });

        return $settings[$slug] ?? $default;
    }
}

if (!function_exists('image')) {
    /**
     * Kiểm tra file trong storage và trả về URL hoặc giá trị mặc định
     *
     * @param string $file Đường dẫn của file
     * @param string $default Giá trị mặc định nếu file không tồn tại
     * @return string URL của file hoặc giá trị mặc định
     */
    function image($file, $default = '/assets/frontend/img/image_placeholder.jpg'): string
    {
        if (is_null($file)) {
            return $default;
        }

        return $file;
    }
}

if (!function_exists('builder')) {
    /**
     * Lấy builder theo tên
     *
     * @param string $slug slug builder cần lấy
     * @param string|null $type Loại hiển thị builder (view)
     * @param array $options Tùy chọn thêm
     * @return \Illuminate\Support\HtmlString|false
     */
    function builder($slug, $type = 'menu.default', array $options = []): bool|HtmlString
    {
        // Lấy thông tin builder từ cache hoặc database
        $builder = Cache::rememberForever("menu-$slug", function () use ($slug) {
            return Menu::where('slug', $slug)->first();
        });

        // Nếu builder không tồn tại, trả về false
        if (!$builder) {
            return false;
        }

        // Lấy danh sách builder item
        $items = Cache::rememberForever("menu-items-$builder->id", function () use ($builder) {
            return MenuItem::with('children')
                ->where('menu_id', $builder->id)
                ->where('status', Common::PUBLISHED->value)
                ->where('parent_id', 0)
                ->orderBy('order')
                ->get();
        });

        return new HtmlString(
            view($type, ['items' => $items, 'options' => $options])->render()
        );
    }
}

if (!function_exists('menu')) {
    /**
     * Lấy menu theo tên
     *
     * @param string $menuName Tên menu cần lấy
     * @param string|null $type Loại hiển thị menu (view)
     * @param array $options Tùy chọn thêm
     * @return \Illuminate\Support\HtmlString|false
     */
    function menu($menuName, $type = 'builder.menu.default', array $options = []): bool|HtmlString
    {
        // Lấy thông tin menu từ cache hoặc database
        $menu = Cache::rememberForever("menu-$menuName", function () use ($menuName) {
            return Menu::where('name', $menuName)->first();
        });

        // Nếu menu không tồn tại, trả về false
        if (!$menu) {
            return false;
        }

        // Lấy danh sách menu item
        $items = Cache::rememberForever("menu-items-$menu->id", function () use ($menu) {
            return MenuItem::with('children')
                ->where('menu_id', $menu->id)
                ->where('parent_id', 0)
                ->orderBy('order')
                ->get();
        });

        return new HtmlString(
            view($type, ['items' => $items, 'options' => $options])->render()
        );
    }
}

if (!function_exists('get_file_name')) {
    function get_file_name($name)
    {
        preg_match('/(_)([0-9])+$/', $name, $matches);
        if (count($matches) == 3) {
            return Illuminate\Support\Str::replaceLast($matches[0], '', $name) . '_' . (intval($matches[2]) + 1);
        } else {
            return $name . '_1';
        }
    }
}

if (!function_exists('recaptcha')) {
    /**
     * @return boolean
     */
    function recaptcha($request_captcha, $secret = null)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret ?? config('recaptcha.site_key'),
            'response' => $request_captcha
        ]);

        if (json_decode($response->getBody(), true)['success'] == true) {
            return true;
        }

        return false;
    }
}
