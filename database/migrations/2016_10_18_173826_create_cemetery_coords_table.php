<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCemeteryCoordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cemetery_coords', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("idCemetery");
            $table->decimal("latitude",10,6);
            $table->decimal("longitude",10,6);
            $table->timestamps();
        });

        Schema::table("cemeteries",function(Blueprint $table)
        {
            $table->string("cadastr_num",30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cemetery_coords');
    }
}
