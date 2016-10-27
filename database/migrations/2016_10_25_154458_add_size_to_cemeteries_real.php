<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSizeToCemeteriesReal extends Migration
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
            $table->removeColumn("cadastr_size");
            $table->removeColumn("cadastr_adres");
        });
        Schema::table("cemeteries",function(Blueprint $table)
        {
            $table->integer("cadastr_size")->nullable();
            $table->string("cadastr_adres")->nullable();
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
