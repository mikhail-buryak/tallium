<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id')->unsigned()->nullable();
            $table->foreign('section_id')
                ->references('id')->on('sections')
                ->onDelete('cascade');
            $table->integer('row');
            $table->integer('place');
            $table->integer('price');

            $table->index(['section_id', 'row'], 'multiple_key_0');
            $table->index('row');
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
}
