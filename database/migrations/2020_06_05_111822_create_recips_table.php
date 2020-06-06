<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meals_id')->unsigned()->default(0);
            $table->foreign('meals_id')->references('id')->on('meals')->onDelete('cascade');
            $table->integer('item_id')->unsigned()->default(0);
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');

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
        Schema::dropIfExists('recips');
    }
}
