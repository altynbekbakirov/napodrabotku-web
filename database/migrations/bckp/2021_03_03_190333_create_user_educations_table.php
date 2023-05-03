<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_educations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('faculty');
            $table->string('speciality');
            $table->integer('end_year');
            $table->bigInteger('type_id')->unsigned();
            $table->foreign('type_id')
                ->references('id')
                ->on('education_types')
                ->onDelete('cascade');
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
        Schema::dropIfExists('user_educations');
    }
}
