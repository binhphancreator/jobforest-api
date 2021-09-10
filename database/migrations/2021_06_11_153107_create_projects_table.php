<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
            $table->string('slug',250)->unique()->nullable();
            $table->longText('content');
            $table->date('deadline_bids');
            $table->enum('type_work',["Dự án","Bán thời gian","Toàn thời gian"]);
            $table->enum('work_form',["Online","Văn phòng"]);
            $table->string('location');
            $table->enum('salary_type',["Dự án","Giờ","Tháng",]);
            $table->integer('budget_min');
            $table->integer('budget_max');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('expertise_id')->constrained('expertises')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onUpdate('cascade')->onDelete('cascade');
            $table->string('file')->nullable();
            $table->enum('status',['offering','working','ended','rated']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
