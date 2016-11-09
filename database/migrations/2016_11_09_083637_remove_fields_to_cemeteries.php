<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsToCemeteries extends Migration
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
            $table->dropColumn("square_filled");
            $table->dropColumn("graveCount");
        });

        Schema::table("graves",function(Blueprint $table)
        {
            $table->dropColumn("numGrave");
            $table->dropColumn("cadastr_size");
            $table->dropColumn("cadastr_adres");
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
