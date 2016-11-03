<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoToCemeteries extends Migration
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
            $table->integer("square_filled")->nullable();
            $table->string("watcher_name")->nullable();
            $table->string("watcher_phone")->nullable();
            $table->string("organisation_name")->nullable();
            $table->integer("graveCount")->nullable();
            $table->integer("idFromRegion22")->nullable();
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
