<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGravesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('graves', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->integer("idCemetery")->unsigned()->nullable();
            $table->integer("numDeads");
            $table->string("sizeGrave",20);
            $table->boolean("hasBorder")->default(false);
            $table->string("border",50)->nullable();
            $table->string("memorial",100)->nullable();
            $table->string("sizeMemorial",20)->nullable();
            $table->integer("state");
            $table->boolean("ww2")->default(false);

            $table->foreign("idCemetery")->references("id")->on("cemeteries");

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
        Schema::dropIfExists('graves');
    }
}
