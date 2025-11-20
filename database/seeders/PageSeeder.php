<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $pages = [
            [
                'user_id'           => 1,
                'title'             => 'Về chúng tôi',
                'slug'              => 'about-us',
                'content'           => 'Giới thiệu về công ty, sứ mệnh và tầm nhìn.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Về chúng tôi',
                'meta_keywords'     => 'giới thiệu, công ty, về chúng tôi',
                'meta_description'  => 'Thông tin về công ty và sứ mệnh.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Liên hệ',
                'slug'              => 'contact',
                'content'           => 'Thông tin liên hệ, địa chỉ và bản đồ.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Liên hệ',
                'meta_keywords'     => 'liên hệ, địa chỉ, số điện thoại',
                'meta_description'  => 'Thông tin liên hệ và hỗ trợ khách hàng.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Chính sách đổi trả',
                'slug'              => 'return-policy',
                'content'           => 'Quy định về đổi trả hàng hoá.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Chính sách đổi trả',
                'meta_keywords'     => 'đổi trả, hoàn hàng, chính sách',
                'meta_description'  => 'Chính sách đổi trả hàng hóa chi tiết.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Chính sách vận chuyển',
                'slug'              => 'shipping-policy',
                'content'           => 'Chính sách giao hàng của chúng tôi bao gồm thời gian vận chuyển, khu vực giao hàng và phí giao hàng nếu có.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Chính sách vận chuyển',
                'meta_keywords'     => 'giao hàng, vận chuyển, chính sách giao hàng',
                'meta_description'  => 'Thông tin về chính sách và thời gian vận chuyển hàng hoá.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Phương thức thanh toán',
                'slug'              => 'payment-methods',
                'content'           => 'Chúng tôi hỗ trợ nhiều hình thức thanh toán như chuyển khoản, thanh toán khi nhận hàng (COD), ví điện tử và quét mã QR.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Phương thức thanh toán',
                'meta_keywords'     => 'thanh toán, COD, chuyển khoản, ví điện tử',
                'meta_description'  => 'Các phương thức thanh toán hỗ trợ khi mua hàng tại cửa hàng.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Chính sách bảo mật',
                'slug'              => 'privacy-policy',
                'content'           => 'Chúng tôi cam kết bảo mật thông tin cá nhân của bạn và chỉ sử dụng chúng để xử lý đơn hàng hoặc liên hệ khi cần.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Chính sách bảo mật',
                'meta_keywords'     => 'chính sách bảo mật, thông tin cá nhân, bảo vệ dữ liệu',
                'meta_description'  => 'Chính sách bảo mật của website bán hàng.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Điều khoản sử dụng',
                'slug'              => 'terms-of-service',
                'content'           => 'Khi sử dụng website, bạn đồng ý tuân thủ các điều khoản sử dụng và quy định của chúng tôi.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Điều khoản sử dụng',
                'meta_keywords'     => 'điều khoản sử dụng, quy định website, sử dụng dịch vụ',
                'meta_description'  => 'Điều khoản và điều kiện khi sử dụng website của chúng tôi.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Câu hỏi thường gặp (FAQ)',
                'slug'              => 'faqs',
                'content'           => 'Tổng hợp các câu hỏi và thắc mắc thường gặp từ khách hàng về đơn hàng, vận chuyển, bảo hành và thanh toán.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Câu hỏi thường gặp',
                'meta_keywords'     => 'FAQ, thắc mắc, hỏi đáp, hỗ trợ khách hàng',
                'meta_description'  => 'Câu hỏi thường gặp giúp bạn hiểu rõ hơn về dịch vụ của chúng tôi.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Chính sách bảo hành',
                'slug'              => 'warranty-policy',
                'content'           => 'Chúng tôi hỗ trợ bảo hành sản phẩm trong thời gian quy định, với các điều kiện bảo hành cụ thể theo từng loại hàng hoá.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Chính sách bảo hành',
                'meta_keywords'     => 'bảo hành, sản phẩm, chính sách bảo hành',
                'meta_description'  => 'Chính sách bảo hành chi tiết áp dụng cho các sản phẩm đã mua.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Hệ thống cửa hàng',
                'slug'              => 'store-system',
                'content'           => 'Danh sách các chi nhánh, đại lý, và cửa hàng trực tiếp của chúng tôi trên toàn quốc.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Hệ thống cửa hàng',
                'meta_keywords'     => 'cửa hàng, hệ thống, chi nhánh, showroom',
                'meta_description'  => 'Tổng hợp các địa chỉ cửa hàng chính thức của thương hiệu.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Hướng dẫn chọn size',
                'slug'              => 'size-guide',
                'content'           => 'Bảng hướng dẫn chọn size chi tiết theo từng loại sản phẩm như quần áo, giày dép.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Hướng dẫn chọn size',
                'meta_keywords'     => 'size, bảng size, chọn size, hướng dẫn chọn size',
                'meta_description'  => 'Cách chọn size phù hợp với bạn dựa trên số đo cơ thể.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Tuyển dụng',
                'slug'              => 'recruitment',
                'content'           => 'Chúng tôi luôn tìm kiếm những ứng viên tiềm năng. Cùng gia nhập đội ngũ của chúng tôi ngay hôm nay!',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Tuyển dụng',
                'meta_keywords'     => 'tuyển dụng, việc làm, cơ hội nghề nghiệp',
                'meta_description'  => 'Thông tin tuyển dụng và cơ hội nghề nghiệp tại công ty.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Khuyến mãi / Tin tức',
                'slug'              => 'promotion',
                'content'           => 'Cập nhật các chương trình khuyến mãi và tin tức mới nhất từ cửa hàng.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Khuyến mãi / Tin tức',
                'meta_keywords'     => 'khuyến mãi, tin tức, ưu đãi, giảm giá',
                'meta_description'  => 'Tổng hợp thông tin khuyến mãi, giảm giá và sự kiện.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
            [
                'user_id'           => 1,
                'title'             => 'Hướng dẫn đặt hàng',
                'slug'              => 'how-to-order',
                'content'           => 'Chi tiết các bước đặt hàng online trên website: chọn sản phẩm, thanh toán và nhận hàng.',
                'image'             => null,
                'template'          => null,
                'status'            => 'published',
                'meta_title'        => 'Hướng dẫn đặt hàng',
                'meta_keywords'     => 'hướng dẫn đặt hàng, mua hàng, quy trình mua hàng',
                'meta_description'  => 'Các bước để đặt hàng thành công và nhanh chóng trên website.',
                'published_at'      => $now,
                'created_at'        => $now,
                'updated_at'        => $now
            ],
        ];

        DB::table('pages')->insert($pages);
    }
}
