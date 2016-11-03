<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCemeteries extends Migration
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
            $table->removeColumn("center_lat");
            $table->removeColumn("center_lon");
        });
        Schema::table("cemeteries",function(Blueprint $table)
        {
            $table->decimal("center_lat",10,8)->nullable();
            $table->decimal("center_lon",10,8)->nullable();
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
