<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ter_objects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nameKg');
            $table->string('nameRu');
            $table->string('nameEn');

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

            $table->bigInteger('rural_area_id')->unsigned()->nullable();
            $table->foreign('rural_area_id')
                ->references('id')
                ->on('rural_areas')
                ->onDelete('cascade');

            $table->bigInteger('village_id')->unsigned()->nullable();
            $table->foreign('village_id')
                ->references('id')
                ->on('villages')
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
        Schema::dropIfExists('ter_objects');
    }
}
