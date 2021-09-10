<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert(['name'=>'Biên tập chỉnh sửa nội dung']);
        DB::table('services')->insert(['name'=>'Chỉnh sửa và dựng video']);
        DB::table('services')->insert(['name'=>'Chỉnh sửa ảnh sản phẩm']);
        DB::table('services')->insert(['name'=>'Chuyển template thành website']);
        DB::table('services')->insert(['name'=>'Dịch văn bản']);
        DB::table('services')->insert(['name'=>'Bảo trì máy tính']);
        DB::table('services')->insert(['name'=>'Biên soạn tài liệu giáo trình']);
        DB::table('services')->insert(['name'=>'Biên tập / Chỉnh sửa nội dung']);
        DB::table('services')->insert(['name'=>'Chụp ảnh sự kiện']);
        DB::table('services')->insert(['name'=>'Chụp ảnh sản phẩm']);
        DB::table('services')->insert(['name'=>'Dựng website bán hàng']);
        DB::table('services')->insert(['name'=>'Đăng bài lên website / tin rao vặt']);
        DB::table('services')->insert(['name'=>'Dựng motion video']);
        DB::table('services')->insert(['name'=>'Dựng phối cảnh 3D']);
        DB::table('services')->insert(['name'=>'Quản lý blog & fanpage']);
        DB::table('services')->insert(['name'=>'Chỉnh sửa và dựng video']);
        DB::table('services')->insert(['name'=>'Quảng cáo facebook']);
        DB::table('services')->insert(['name'=>'Thiết kế flyer']);
        DB::table('services')->insert(['name'=>'Thiết kế banner quảng cáo']);
        DB::table('services')->insert(['name'=>'Gia sư']);
        DB::table('services')->insert(['name'=>'Khắc phục sự cố mạng']);
        DB::table('services')->insert(['name'=>'Viết phần mềm theo yêu cầu']);
        DB::table('services')->insert(['name'=>'Bảo trì các dự án phần mềm']);
        DB::table('services')->insert(['name'=>'Làm app IOS']);
        DB::table('services')->insert(['name'=>'Làm mobile app theo yêu cầu']);
        DB::table('services')->insert(['name'=>'Thiết kế giao diện mobile app']);
        DB::table('services')->insert(['name'=>'Thiết kế giao diện website']);
        DB::table('services')->insert(['name'=>'Thiết kế logo']);
        DB::table('services')->insert(['name'=>'Thiết kế poster']);
        DB::table('services')->insert(['name'=>'Thiết kế nội thất']);
        DB::table('services')->insert(['name'=>'Thiết kế UI/UX']);
        DB::table('services')->insert(['name'=>'Thiết kế thiệp']);
        DB::table('services')->insert(['name'=>'Thiết kế sticker']);
        DB::table('services')->insert(['name'=>'Thiết kế khác']);
        DB::table('services')->insert(['name'=>'Thiết kế landingpage']);
        DB::table('services')->insert(['name'=>'Tư vấn']);
        DB::table('services')->insert(['name'=>'Viết bài']);
        DB::table('services')->insert(['name'=>'Viết kịch bản']);
        DB::table('services')->insert(['name'=>'Viết nội dung cho blog']);
        DB::table('services')->insert(['name'=>'Xử lý dữ liệu']);
        DB::table('services')->insert(['name'=>'Tối ưu SEO cho website']);
        DB::table('services')->insert(['name'=>'Forum seeding']);
        DB::table('services')->insert(['name'=>'Lập trình phần mềm']);
        DB::table('services')->insert(['name'=>'Lập báo cáo tài chính']);
        DB::table('services')->insert(['name'=>'Lập kế hoạch kinh doanh']);
        DB::table('services')->insert(['name'=>'Phát triển ứng dụng web']);
        DB::table('services')->insert(['name'=>'Phiên dịch']);
        DB::table('services')->insert(['name'=>'Test và kiểm tra lỗi']);
    }
}
