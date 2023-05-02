<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_title');
            $table->string('organization_name');
            $table->string('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
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
        Schema::dropIfExists('user_experiences');
    }
}
