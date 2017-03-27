<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLockerLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('locker_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('building');
            $table->string('floor');
            $table->unique(['building', 'floor']);
            $table->date('date_added');
            $table->integer('added_by');

        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('locker_locations');
    }
}
