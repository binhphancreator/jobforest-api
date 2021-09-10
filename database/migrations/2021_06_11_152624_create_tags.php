<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
        });

        Schema::create('expertises', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills');
        Schema::dropIfExists('services');
        Schema::dropIfExists('expertises');
    }
}
