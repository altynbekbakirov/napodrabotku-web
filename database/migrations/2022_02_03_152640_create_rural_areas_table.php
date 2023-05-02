<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuralAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rural_areas', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('nameKg')->nullable();
            $table->string('nameRu')->nullable();
            $table->string('nameEn')->nullable();

            // TODO убрать '_id' если возникнет ошибка
            $table->bigInteger('region_id')->unsigned()->nullable();
            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->onDelete('cascade');

            $table->bigInteger('district_id')->unsigned()->nullable();
            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
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
        Schema::dropIfExists('rural_areas');
    }
}
