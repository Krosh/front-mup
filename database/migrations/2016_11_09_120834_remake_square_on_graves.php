<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemakeSquareOnGraves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("graves",function(Blueprint $table)
        {
            $table->dropColumn("square");
        });
        Schema::table("graves",function(Blueprint $table)
        {
            $table->bigInteger("square",false,true)->nullable()->default(0);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
