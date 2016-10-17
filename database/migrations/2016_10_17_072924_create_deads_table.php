<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("idGrave")->nullable()->unsigned();
            $table->string("family")->nullable();
            $table->string("name")->nullable();
            $table->string("patron")->nullable();
            $table->integer("yearBorn")->nullable();
            $table->integer("yearDeath")->nullable();

            $table->foreign("idGrave")->references("id")->on("graves");
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
        Schema::dropIfExists('deads');
    }
}
