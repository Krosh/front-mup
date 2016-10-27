<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetGraveNumGraveAsNullable extends Migration
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
            $table->dropColumn("numGrave");

        });

        Schema::table("graves",function(Blueprint $table)
        {
            $table->string("numGrave")->nullable();
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
