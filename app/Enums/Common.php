<?php

namespace App\Enums;

enum Common: string
{
    // Trạng thái chung
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    // Vai trò người dùng
    case ADMIN = 'admin';
    case SUPERADMIN = 'superadmin';
    case USER = 'user';
    case EDITOR = 'editor';

    // Giới tính
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

    // Kiểu mở link (_self, _blank,...)
    case TARGET_SELF = '_self';
    case TARGET_BLANK = '_blank';

    // Loại menu
    case MENU_HEADER = 'header';
    case MENU_FOOTER = 'footer';
    case MENU_SIDEBAR = 'sidebar';

    // Quyền hạn
    case PERMISSION_CREATE = 'create';
    case PERMISSION_EDIT = 'edit';
    case PERMISSION_DELETE = 'delete';
    case PERMISSION_VIEW = 'view';

    // Ngôn ngữ hỗ trợ
    case LANGUAGE_EN = 'en';
    case LANGUAGE_VI = 'vi';

    // Loại chuyên mục (category types)
    case CATEGORY_POST = 'post';
    case CATEGORY_PRODUCT = 'product';
    case CATEGORY_PROJECT = 'project';

    /**
     * Trả về tên hiển thị của enum
     */
    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Hoạt động',
            self::INACTIVE => 'Không hoạt động',
            self::DRAFT => 'Bản nháp',
            self::PUBLISHED => 'Đã xuất bản',
            self::ARCHIVED => 'Đã lưu trữ',
            self::ADMIN => 'Quản trị viên',
            self::SUPERADMIN => 'Super Admin',
            self::USER => 'Người dùng',
            self::EDITOR => 'Biên tập viên',
            self::MALE => 'Nam',
            self::FEMALE => 'Nữ',
            self::OTHER => 'Khác',
            self::TARGET_SELF => 'Mở trong trang hiện tại',
            self::TARGET_BLANK => 'Mở trong tab mới',
            self::MENU_HEADER => 'Menu Header',
            self::MENU_FOOTER => 'Menu Footer',
            self::MENU_SIDEBAR => 'Menu Sidebar',
            self::PERMISSION_CREATE => 'Tạo mới',
            self::PERMISSION_EDIT => 'Chỉnh sửa',
            self::PERMISSION_DELETE => 'Xóa',
            self::PERMISSION_VIEW => 'Xem',
            self::LANGUAGE_EN => 'English',
            self::LANGUAGE_VI => 'Tiếng Việt',
            self::CATEGORY_POST => 'Bài viết',
            self::CATEGORY_PRODUCT => 'Sản phẩm',
            self::CATEGORY_PROJECT => 'Dự án',
        };
    }

    /**
     * Lấy danh sách trạng thái
     */
    public static function getStatuses(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
            self::DRAFT,
            self::ARCHIVED,
        ];
    }

    public static function getStatusesKind(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE
        ];
    }

    public static function getStatusesKindWithLabel(): array
    {
        return [
            self::ACTIVE->value => self::ACTIVE->label(),
            self::INACTIVE->value => self::INACTIVE->label()
        ];
    }

    /**
     * Lấy danh sách trạng thái cơ bản với label
     */
    public static function getStatusesBaseWithLabel(): array
    {
        return [
            self::DRAFT->value => self::DRAFT->label(),
            self::PUBLISHED->value => self::PUBLISHED->label()
        ];
    }

    /**
     * Lấy danh sách vai trò
     */
    public static function getRoles(): array
    {
        return [
            self::ADMIN,
            self::SUPERADMIN,
            self::USER,
            self::EDITOR,
        ];
    }

    public static function getRolesWithLabel(): array
    {
        return [
            self::SUPERADMIN->value => self::SUPERADMIN->label(),
            self::ADMIN->value => self::ADMIN->label(),
            self::USER->value => self::USER->label(),
            self::EDITOR->value => self::EDITOR->label(),
        ];
    }

    /**
     * Lấy danh sách giới tính
     */
    public static function getGenders(): array
    {
        return [
            self::MALE,
            self::FEMALE,
            self::OTHER,
        ];
    }

    public static function getGendersWithLabel(): array
    {
        return [
            self::MALE->value => self::MALE->label(),
            self::FEMALE->value => self::FEMALE->label(),
            self::OTHER->value => self::OTHER->label()
        ];
    }

    /**
     * Lấy danh sách kiểu mở link (_self, _blank)
     */
    public static function getTargets(): array
    {
        return [
            self::TARGET_SELF,
            self::TARGET_BLANK,
        ];
    }

    /**
     * Lấy danh sách loại menu
     */
    public static function getMenuTypes(): array
    {
        return [
            self::MENU_HEADER,
            self::MENU_FOOTER,
            self::MENU_SIDEBAR,
        ];
    }

    /**
     * Lấy danh sách quyền hạn
     */
    public static function getPermissions(): array
    {
        return [
            self::PERMISSION_CREATE,
            self::PERMISSION_EDIT,
            self::PERMISSION_DELETE,
            self::PERMISSION_VIEW,
        ];
    }

    /**
     * Lấy danh sách ngôn ngữ hỗ trợ
     */
    public static function getLanguages(): array
    {
        return [
            self::LANGUAGE_EN,
            self::LANGUAGE_VI,
        ];
    }

    /**
     * Lấy danh sách loại chuyên mục
     */
    public static function getCategoryTypes(): array
    {
        return [
            self::CATEGORY_POST,
            self::CATEGORY_PRODUCT,
            self::CATEGORY_PROJECT,
        ];
    }
}
