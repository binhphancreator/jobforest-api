<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type',['Freelancer','Nhà tuyển dụng'])->nullable();
            $table->string('title')->nullable();
            $table->text('introduction')->nullable();
            $table->string('website')->nullable();
            $table->foreignId('expertise_id')->nullable()->constrained('expertises')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('qualification',["Mới đi làm","Đã có kinh nghiệm","Chuyên gia"])->nullable();
            $table->timestamps();
            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
