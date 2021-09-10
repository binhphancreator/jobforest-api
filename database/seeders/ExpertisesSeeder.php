<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpertisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expertises')->insert(['name'=>'Lập trình web']);
        DB::table('expertises')->insert(['name'=>'Ứng dụng di động']);
        DB::table('expertises')->insert(['name'=>'Lập trình phần mềm']);
        DB::table('expertises')->insert(['name'=>'QA Tester']);
        DB::table('expertises')->insert(['name'=>'Tư vấn thiết kế hệ thống mạng']);
        DB::table('expertises')->insert(['name'=>'Quản lý dự án']);
        DB::table('expertises')->insert(['name'=>'Lập trình nhúng']);
        DB::table('expertises')->insert(['name'=>'Quảng cáo facebook']);
        DB::table('expertises')->insert(['name'=>'Email marketing']);
        DB::table('expertises')->insert(['name'=>'Tiếp thị liên kết']);
        DB::table('expertises')->insert(['name'=>'Thiết kế logo']);
        DB::table('expertises')->insert(['name'=>'Thiết kế đồ hoạ']);
        DB::table('expertises')->insert(['name'=>'Thiết kế giao diện website']);
        DB::table('expertises')->insert(['name'=>'Thiết kế']);
        DB::table('expertises')->insert(['name'=>'Ảnh và chỉnh sửa ảnh']);
        DB::table('expertises')->insert(['name'=>'Thiết kế giao diện ứng dụng di động']);
        DB::table('expertises')->insert(['name'=>'Banner quảng cáo']);
        DB::table('expertises')->insert(['name'=>'Nhãn hiệu và bao bì']);
        DB::table('expertises')->insert(['name'=>'Làm video clip']);
        DB::table('expertises')->insert(['name'=>'Thiết kế giao diện ứng dụng di động']);
        DB::table('expertises')->insert(['name'=>'Video hoạt hình']);
        DB::table('expertises')->insert(['name'=>'TVC giới thiệu sản phẩm công ty']);
        DB::table('expertises')->insert(['name'=>'Gia sư']);
        DB::table('expertises')->insert(['name'=>'Ngoại ngữ']);
        DB::table('expertises')->insert(['name'=>'Đào tạo kỹ năng mềm']);
        DB::table('expertises')->insert(['name'=>'Khác']);
    }
}
