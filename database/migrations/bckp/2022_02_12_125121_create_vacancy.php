<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('salary');
            $table->boolean('is_active')->default(true);

            $table->bigInteger('busyness_id')->nullable()->unsigned();
            $table->foreign('busyness_id')
                ->references('id')
                ->on('bussynesses')
                ->onDelete('cascade');

            $table->bigInteger('schedule_id')->nullable()->unsigned();
            $table->foreign('schedule_id')
                ->references('id')
                ->on('schedules')
                ->onDelete('cascade');

            $table->bigInteger('job_type_id')->nullable()->unsigned();
            $table->foreign('job_type_id')
                ->references('id')
                ->on('job_types')
                ->onDelete('cascade');

            $table->bigInteger('vacancy_type_id')->nullable()->unsigned();
            $table->foreign('vacancy_type_id')
                ->references('id')
                ->on('vacancy_types')
                ->onDelete('cascade');

            $table->bigInteger('region_id')->nullable()->unsigned();
            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->onDelete('cascade');

            $table->bigInteger('company_id')->nullable()->unsigned();
            $table->foreign('company_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->bigInteger('department_id')->nullable()->unsigned();
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');


            $table->bigInteger('social_orientation_id')->nullable()->unsigned();
            $table->foreign('social_orientation_id')
                ->references('id')
                ->on('social_orientations')
                ->onDelete('cascade');

            $table->bigInteger('opportunity_id')->nullable()->unsigned();
            $table->foreign('opportunity_id')
                ->references('id')
                ->on('opportunities')
                ->onDelete('cascade');



            $table->bigInteger('opportunity_type_id')->nullable()->unsigned();
            $table->bigInteger('opportunity_duration_id')->nullable()->unsigned();
            $table->bigInteger('internship_language_id')->nullable()->unsigned();
            $table->bigInteger('recommendation_letter_type_id')->nullable()->unsigned();
            $table->bigInteger('currency')->nullable()->unsigned();

            $table->string('salary_from')->nullable();
            $table->string('salary_to')->nullable();
            $table->string('age_from');
            $table->string('age_to');

            $table->boolean('is_disability_person_vacancy')->default(false);
            $table->integer('is_product_lab_vacancy')->default(false);

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
        Schema::dropIfExists('vacancies');
    }
}
