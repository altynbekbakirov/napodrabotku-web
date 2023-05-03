<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('organization_name');
            $table->integer('end_year');
            $table->string('duration');
            $table->bigInteger('user_cv_id')->unsigned();
            $table->foreign('user_cv_id')
                ->references('id')
                ->on('user_cvs')
                ->onDelete('cascade');
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
        Schema::dropIfExists('user_courses');
    }
}
