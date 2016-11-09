<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestFieldsToCemeteries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("cemeteries",function(Blueprint $table)
        {
            $table->integer("idParentCemetery")->nullable();
            $table->boolean("hasTestData")->default(false);
            $table->integer("test_square")->nullable()->default(0);
            $table->integer("test_graveCount")->nullable()->default(0);
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
