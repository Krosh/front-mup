<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemakeDeadDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("deads",function(Blueprint $table)
        {
            $table->date("dateBorn")->nullable();
            $table->date("dateDeath")->nullable();
        });
        Schema::table("graves",function(Blueprint $table)
        {
            $table->integer("idFromRegsystem")->nullable();
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
