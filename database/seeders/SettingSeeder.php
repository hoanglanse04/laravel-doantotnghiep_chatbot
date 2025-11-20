<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('setting_fields')->truncate();
        DB::table('settings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $settings = [
            // Mục lớn (Tab chính)
            ['id' => 1, 'name' => 'Cài đặt chung', 'slug' => 'general', 'description' => 'Cài đặt chung của hệ thống', 'parent_id' => null, 'order' => 1],
            ['id' => 2, 'name' => 'Quy trình tự động', 'slug' => 'system-settings', 'description' => 'Cấu hình hệ thống', 'parent_id' => null, 'order' => 2],
            ['id' => 3, 'name' => 'Báo cáo & phân tích', 'slug' => 'staff-permissions', 'description' => 'Quản lý nhân viên và phân quyền', 'parent_id' => null, 'order' => 3],
            ['id' => 4, 'name' => 'Hệ thống thông báo & liên lạc', 'slug' => 'reports-analytics', 'description' => 'Báo cáo doanh thu và dữ liệu', 'parent_id' => null, 'order' => 4],
            ['id' => 5, 'name' => 'Đơn hàng & thanh toán', 'slug' => 'notifications-communication', 'description' => 'Cấu hình thông báo và phương thức liên lạc', 'parent_id' => null, 'order' => 5],

            // Tiêu đề nhóm thuộc từng tab (dạng nhóm cài đặt)
            // Cài đặt chung
            ['id' => 10, 'name' => 'Thông tin về cửa hàng', 'slug' => 'info', 'description' => 'Thông tin cơ bản của cửa hàng', 'parent_id' => 1, 'order' => 1],
            ['id' => 11, 'name' => 'Liên kết mạng xã hội', 'slug' => 'social_network_links', 'description' => 'Liên kết mạng xã hội', 'parent_id' => 1, 'order' => 2],

            // Cài đặt hệ thống
            ['id' => 20, 'name' => 'Sao lưu & Khôi phục', 'slug' => 'backup-settings', 'description' => 'Cài đặt sao lưu và khôi phục dữ liệu', 'parent_id' => 2, 'order' => 1],
            ['id' => 21, 'name' => 'Tối ưu hiệu suất', 'slug' => 'performance-optimization', 'description' => 'Tối ưu tốc độ và hiệu suất', 'parent_id' => 2, 'order' => 2],

            // Nhân viên & Phân quyền
            ['id' => 30, 'name' => 'Quản lý vai trò', 'slug' => 'roles-permissions', 'description' => 'Phân quyền cho từng nhóm nhân viên', 'parent_id' => 3, 'order' => 1],

            // Báo cáo & Phân tích
            ['id' => 40, 'name' => 'Báo cáo doanh thu', 'slug' => 'sales-reports', 'description' => 'Xem doanh thu theo thời gian', 'parent_id' => 4, 'order' => 1],
            ['id' => 41, 'name' => 'Phân tích khách hàng', 'slug' => 'customer-insights', 'description' => 'Dữ liệu về khách hàng và hành vi mua hàng', 'parent_id' => 4, 'order' => 2],

            // Thông báo & Liên lạc
            ['id' => 50, 'name' => 'Cấu hình Email & SMS', 'slug' => 'email-sms', 'description' => 'Cài đặt email và tin nhắn SMS', 'parent_id' => 4, 'order' => 1],
            ['id' => 51, 'name' => 'Thông báo đẩy', 'slug' => 'push-notifications', 'description' => 'Cấu hình thông báo trên trình duyệt và di động', 'parent_id' => 4, 'order' => 2],

            // Đơn hàng & Thanh toán
            ['id' => 60, 'name' => 'Phương thức thanh toán', 'slug' => 'payment-methods', 'description' => 'Cài đặt các phương thức thanh toán', 'parent_id' => 5, 'order' => 1],
            ['id' => 61, 'name' => 'Vận chuyển & Giao hàng', 'slug' => 'shipping-delivery', 'description' => 'Cấu hình khu vực và phương thức giao hàng', 'parent_id' => 5, 'order' => 2],
        ];

        foreach ($settings as $setting) {
            $settingId = DB::table('settings')->insertGetId(array_merge($setting, ['created_at' => now(), 'updated_at' => now()]));

            $fields = $this->getSettingFields($setting['slug']);
            foreach ($fields as $field) {
                DB::table('setting_fields')->insert(array_merge($field, ['group_id' => $settingId, 'created_at' => now(), 'updated_at' => now()]));
            }
        }
    }

    private function getSettingFields($slug): array
    {
        $fields = [
            'info' => [
                [
                    'group_id' => 1,
                    'name' => 'Tên website',
                    'slug' => 'site_name',
                    'type' => 'text',
                    'value' => 'Tên thương hiệu',
                    'is_required' => true,
                    'placeholder' => 'Enter site name',
                    'description' => 'Tên website hiển thị trên tiêu đề trang.',
                    'validation' => json_encode(['required', 'string', 'max:255']),
                    'attributes' => json_encode(['class' => 'form-control']),
                    'order' => 1,
                ], [
                    'group_id' => 1,
                    'name' => 'Mô tả website',
                    'slug' => 'site_description',
                    'type' => 'textarea',
                    'value' => 'Mô tả thương hiệu',
                    'is_required' => false,
                    'placeholder' => 'Enter website description',
                    'description' => 'Mô tả website dùng cho SEO.',
                    'validation' => json_encode(['string', 'max:500']),
                    'attributes' => json_encode(['rows' => 3]),
                    'order' => 2,
                ], [
                    'group_id' => 1,
                    'name' => 'Từ khóa tìm kiếm',
                    'slug' => 'site_keywords',
                    'type' => 'text',
                    'value' => 'shopping, ecommerce',
                    'is_required' => false,
                    'placeholder' => 'Từ khóa tìm kiếm',
                    'description' => 'Từ khóa giúp tối ưu SEO.',
                    'validation' => json_encode(['string', 'max:255']),
                    'attributes' => null,
                    'order' => 3,
                ], [
                    'group_id' => 2,
                    'name' => 'Ảnh Logo',
                    'slug' => 'site_logo',
                    'type' => 'image',
                    'value' => '',
                    'is_required' => false,
                    'placeholder' => null,
                    'description' => 'Logo hiển thị trên trang chủ.',
                    'validation' => json_encode(['nullable', 'image', 'mimes:jpeg,png,webp']),
                    'attributes' => null,
                    'order' => 4,
                ], [
                    'group_id' => 2,
                    'name' => 'Favicon',
                    'slug' => 'favicon',
                    'type' => 'image',
                    'value' => '',
                    'is_required' => false,
                    'placeholder' => null,
                    'description' => 'Biểu tượng website hiển thị trên tab trình duyệt.',
                    'validation' => json_encode(['nullable', 'image', 'mimes:png,ico']),
                    'attributes' => null,
                    'order' => 5,
                ], [
                    'group_id' => 3,
                    'name' => 'Store Status',
                    'slug' => 'store_status',
                    'type' => 'select',
                    'options' => json_encode(['Active' => 'Hoạt động', 'Maintenance' => 'Bảo trì', 'Closed' => 'Đóng cửa']),
                    'value' => 'Active',
                    'is_required' => true,
                    'placeholder' => null,
                    'description' => 'Trạng thái cửa hàng.',
                    'validation' => json_encode(['required', 'string']),
                    'attributes' => null,
                    'order' => 6,
                ], [
                    'group_id' => 3,
                    'name' => 'Giờ làm việc',
                    'slug' => 'business_hours',
                    'type' => 'text',
                    'value' => '9:00 AM - 7:00 PM',
                    'is_required' => false,
                    'placeholder' => 'Nhập giờ làm việc',
                    'description' => 'Thời gian làm việc của cửa hàng.',
                    'validation' => json_encode(['string']),
                    'attributes' => null,
                    'order' => 7,
                ], [
                    'group_id' => 3,
                    'name' => 'Google Maps',
                    'slug' => 'google_maps',
                    'type' => 'textarea',
                    'value' => 'Dán thẻ iframe bản đồ vào đây',
                    'is_required' => true,
                    'placeholder' => null,
                    'description' => 'Nhúng embed thẻ iframe trong Google Maps',
                    'attributes' => null,
                    'order' => 8,
                ], [
                    'group_id' => 4,
                    'name' => 'Language',
                    'slug' => 'language',
                    'type' => 'select',
                    'options' => json_encode(['en' => 'English', 'vi' => 'Vietnamese']),
                    'value' => 'vi',
                    'is_required' => true,
                    'placeholder' => null,
                    'description' => 'Ngôn ngữ chính của website.',
                    'validation' => json_encode(['required', 'string']),
                    'attributes' => null,
                    'order' => 9,
                ], [
                    'group_id' => 4,
                    'name' => 'Email',
                    'slug' => 'contact_email',
                    'type' => 'email',
                    'value' => 'support@myshop.com',
                    'is_required' => true,
                    'placeholder' => 'Enter contact email',
                    'description' => 'Email liên hệ chính.',
                    'validation' => json_encode(['required', 'email']),
                    'attributes' => null,
                    'order' => 10,
                ], [
                    'group_id' => 4,
                    'name' => 'Số điện thoại',
                    'slug' => 'contact_phone',
                    'type' => 'text',
                    'value' => '+123456789',
                    'is_required' => true,
                    'placeholder' => 'Enter phone number',
                    'description' => 'Số điện thoại liên hệ.',
                    'validation' => json_encode(['required', 'string', 'max:20']),
                    'attributes' => null,
                    'order' => 11,
                ], [
                    'group_id' => 4,
                    'name' => 'Địa chỉ',
                    'slug' => 'address',
                    'type' => 'textarea',
                    'value' => '123 Main Street, City, Country',
                    'is_required' => true,
                    'placeholder' => 'Enter address',
                    'description' => 'Địa chỉ cửa hàng hoặc công ty.',
                    'validation' => json_encode(['required', 'string']),
                    'attributes' => json_encode(['rows' => 3]),
                    'order' => 12,
                ],
            ],

            'social_network_links' => [
                [
                    'group_id' => 11,
                    'name' => 'Facebook',
                    'slug' => 'social_facebook',
                    'type' => 'text',
                    'value' => 'Mạng xã hội Facebook',
                    'is_required' => false,
                    'placeholder' => 'Mạng xã hội Facebook',
                    'description' => 'Liên kết Facebook',
                    'validation' => json_encode(['string']),
                    'attributes' => null,
                    'order' => 1
                ],
                [
                    'group_id' => 11,
                    'name' => 'Instagram',
                    'slug' => 'social_instagram',
                    'type' => 'text',
                    'value' => 'Mạng xã hội Instagram',
                    'is_required' => false,
                    'placeholder' => 'Mạng xã hội Instagram',
                    'description' => 'Liên kết Instagram',
                    'validation' => json_encode(['string']),
                    'attributes' => null,
                    'order' => 2
                ],
                [
                    'group_id' => 11,
                    'name' => 'Twitter',
                    'slug' => 'social_twitter',
                    'type' => 'text',
                    'value' => 'Mạng xã hội Twitter',
                    'is_required' => false,
                    'placeholder' => 'Mạng xã hội Twitter',
                    'description' => 'Liên kết Twitter (X)',
                    'validation' => json_encode(['string']),
                    'attributes' => null,
                    'order' => 3
                ],
                [
                    'group_id' => 11,
                    'name' => 'LinkedIn',
                    'slug' => 'social_linkedin',
                    'type' => 'text',
                    'value' => 'Mạng xã hội LinkedIn',
                    'is_required' => false,
                    'placeholder' => 'Mạng xã hội LinkedIn',
                    'description' => 'Liên kết LinkedIn',
                    'validation' => json_encode(['string']),
                    'attributes' => null,
                    'order' => 4
                ],
                [
                    'group_id' => 11,
                    'name' => 'YouTube',
                    'slug' => 'social_youtube',
                    'type' => 'text',
                    'value' => 'Mạng xã hội YouTube',
                    'is_required' => false,
                    'placeholder' => 'Mạng xã hội YouTube',
                    'description' => 'Liên kết YouTube',
                    'validation' => json_encode(['string']),
                    'attributes' => null,
                    'order' => 5
                ],
                [
                    'group_id' => 11,
                    'name' => 'TikTok',
                    'slug' => 'social_tiktok',
                    'type' => 'text',
                    'value' => 'Mạng xã hội TikTok',
                    'is_required' => false,
                    'placeholder' => 'Mạng xã hội TikTok',
                    'description' => 'Liên kết TikTok',
                    'validation' => json_encode(['string']),
                    'attributes' => null,
                    'order' => 6
                ],
                [
                    'group_id' => 11,
                    'name' => 'Zalo',
                    'slug' => 'social_zalo',
                    'type' => 'text',
                    'value' => 'Mạng xã hội Zalo',
                    'is_required' => false,
                    'placeholder' => 'Mạng xã hội Zalo',
                    'description' => 'Liên kết Zalo',
                    'validation' => json_encode(['string']),
                    'attributes' => null,
                    'order' => 7
                ],
                [
                    'group_id' => 11,
                    'name' => 'Pinterest',
                    'slug' => 'social_pinterest',
                    'type' => 'text',
                    'value' => 'Mạng xã hội Pinterest',
                    'is_required' => false,
                    'placeholder' => 'Mạng xã hội Pinterest',
                    'description' => 'Liên kết Pinterest',
                    'validation' => json_encode(['string']),
                    'attributes' => null,
                    'order' => 8
                ],
                [
                    'group_id' => 11,
                    'name' => 'Reddit',
                    'slug' => 'social_reddit',
                    'type' => 'text',
                    'value' => 'Mạng xã hội Reddit',
                    'is_required' => false,
                    'placeholder' => 'Mạng xã hội Reddit',
                    'description' => 'Liên kết Reddit',
                    'validation' => json_encode(['string']),
                    'attributes' => null,
                    'order' => 9
                ]
            ],

            'backup-settings' => [
                ['name' => 'Backup Frequency', 'slug' => 'backup_frequency', 'type' => 'select', 'options' => json_encode(['Daily', 'Weekly', 'Monthly']), 'value' => 'Weekly'],
                ['name' => 'Auto Backup', 'slug' => 'auto_backup', 'type' => 'checkbox', 'value' => '1'],
                ['name' => 'Restore Backup', 'slug' => 'restore_backup', 'type' => 'file', 'value' => ''],
                ['name' => 'Cache Expiration', 'slug' => 'cache_expiration', 'type' => 'number', 'value' => '60'],
                ['name' => 'Performance Mode', 'slug' => 'performance_mode', 'type' => 'select', 'options' => json_encode(['Normal', 'High', 'Ultra']), 'value' => 'High'],
                ['name' => 'Error Logging', 'slug' => 'error_logging', 'type' => 'checkbox', 'value' => '1'],
                ['name' => 'Maintenance Mode', 'slug' => 'maintenance_mode', 'type' => 'checkbox', 'value' => '0'],
                ['name' => 'API Access', 'slug' => 'api_access', 'type' => 'checkbox', 'value' => '1'],
                ['name' => 'Allowed IPs', 'slug' => 'allowed_ips', 'type' => 'textarea', 'value' => ''],
            ],
            'roles-permissions' => [
                ['name' => 'Staff Name', 'slug' => 'staff_name', 'type' => 'text', 'value' => ''],
                ['name' => 'Email', 'slug' => 'staff_email', 'type' => 'email', 'value' => ''],
                ['name' => 'Role', 'slug' => 'staff_role', 'type' => 'select', 'options' => json_encode(['Admin', 'Manager', 'Support', 'Sales']), 'value' => 'Manager'],
                ['name' => 'Permissions', 'slug' => 'staff_permissions', 'type' => 'multi-select', 'options' => json_encode(['View', 'Edit', 'Delete', 'Manage']), 'value' => 'View'],
                ['name' => 'Status', 'slug' => 'staff_status', 'type' => 'select', 'options' => json_encode(['Active', 'Suspended']), 'value' => 'Active'],
                ['name' => 'Last Login', 'slug' => 'staff_last_login', 'type' => 'text', 'value' => ''],
            ],
            'sales-reports' => [
                ['name' => 'Sales Reports', 'slug' => 'sales_reports', 'type' => 'date-range', 'value' => ''],
                ['name' => 'Best Selling Products', 'slug' => 'best_selling_products', 'type' => 'select', 'options' => json_encode(['Last 7 days', 'Last 30 days']), 'value' => 'Last 7 days'],
                ['name' => 'Customer Insights', 'slug' => 'customer_insights', 'type' => 'text', 'value' => ''],
                ['name' => 'Order Conversion Rate', 'slug' => 'order_conversion_rate', 'type' => 'text', 'value' => ''],
                ['name' => 'Average Order Value', 'slug' => 'average_order_value', 'type' => 'text', 'value' => ''],
                ['name' => 'Return Rate', 'slug' => 'return_rate', 'type' => 'text', 'value' => ''],
            ],
            'push-notifications' => [
                ['name' => 'Email Notifications', 'slug' => 'email_notifications', 'type' => 'checkbox', 'value' => '1'],
                ['name' => 'SMS Notifications', 'slug' => 'sms_notifications', 'type' => 'checkbox', 'value' => '1'],
                ['name' => 'Telegram Bot Token', 'slug' => 'telegram_bot_token', 'type' => 'text', 'value' => ''],
                ['name' => 'Telegram Chat ID', 'slug' => 'telegram_chat_id', 'type' => 'text', 'value' => ''],
                ['name' => 'Web Push Notifications', 'slug' => 'web_push_notifications', 'type' => 'checkbox', 'value' => '1'],
                ['name' => 'Mobile Push Notifications', 'slug' => 'mobile_push_notifications', 'type' => 'checkbox', 'value' => '1'],
                ['name' => 'Order Notifications', 'slug' => 'order_notifications', 'type' => 'select', 'options' => json_encode(['Email', 'SMS', 'Telegram', 'Push']), 'value' => 'Email'],
            ],
            'payment-methods' => [
                ['name' => 'Minimum Order Amount', 'slug' => 'minimum_order_amount', 'type' => 'number', 'value' => '10'],
                ['name' => 'Auto Cancel Unpaid Orders', 'slug' => 'auto_cancel_unpaid_orders', 'type' => 'checkbox', 'value' => '1'],
                ['name' => 'Payment Methods', 'slug' => 'payment_methods', 'type' => 'multi-select', 'options' => json_encode(['Credit Card', 'PayPal', 'COD']), 'value' => 'Credit Card'],
                ['name' => 'COD Availability', 'slug' => 'cod_availability', 'type' => 'checkbox', 'value' => '1'],
                ['name' => 'Shipping Zones', 'slug' => 'shipping_zones', 'type' => 'multi-select', 'options' => json_encode(['USA', 'Vietnam', 'Europe']), 'value' => 'USA'],
                ['name' => 'Estimated Delivery Time', 'slug' => 'estimated_delivery_time', 'type' => 'number', 'value' => '3'],
                ['name' => 'Tax Calculation', 'slug' => 'tax_calculation', 'type' => 'checkbox', 'value' => '1'],
                ['name' => 'Invoice Auto-Generation', 'slug' => 'invoice_auto_generation', 'type' => 'checkbox', 'value' => '1'],
            ],
        ];

        return $fields[$slug] ?? [];
    }
}
