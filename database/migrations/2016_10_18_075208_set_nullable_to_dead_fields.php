<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullableToDeadFields extends Migration
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
            $table->dropColumn("memorial");
            $table->dropColumn("sizeMemorial");
            $table->dropColumn("memorialMaterial");

        });

        Schema::table("deads",function(Blueprint $table)
        {
            $table->string("memorial")->nullable();
            $table->string("sizeMemorial")->nullable();
            $table->string("memorialMaterial")->nullable();
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
