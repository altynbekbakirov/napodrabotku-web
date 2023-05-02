<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('login')->nullable();
            $table->string('avatar')->nullable();

            $table->string('name');
            $table->string('lastname')->nullable();

            $table->string('email')->nullable();
            $table->string('password')->nullable();

            $table->date('birth_date')->nullable();

            $table->enum('type', ['ADMIN', 'COMPANY', 'USER']);
            $table->string('linkedin')->nullable();

            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();

            $table->boolean('active')->default(0);

            $table->boolean('is_migrant')->default(false);

            $table->boolean('gender')->default(0);
            $table->integer('region')->nullable();

            $table->string('filter_region')->nullable();
            $table->string('filter_activity')->nullable();
            $table->string('filter_type')->nullable();
            $table->string('filter_busyness')->nullable();
            $table->string('filter_schedule')->nullable();
            $table->string('filter_district')->nullable();

            $table->integer('district')->nullable();
            $table->integer('job_type')->nullable();

            $table->string('contact_person_fullname')->nullable();
            $table->string('contact_person_position')->nullable();
            $table->integer('job_sphere')->nullable();
            $table->integer('department')->nullable();
            $table->integer('social_orientation')->nullable();

            $table->boolean('is_product_lab_user')->default(0);


            $table->rememberToken();
            $table->timestamps(); // 2 columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
