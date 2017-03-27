<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('venue');       
            $table->string('organization');
            $table->string('school_year');
            $table->enum('status', array('OnProcess', 'Reserved', 'Banned'));
            $table->timestamp('start');
            $table->timestamp('end')->nullable();
            // $table->datetime('start');
            // $table->datetime('end');

            $table->enum('remark_status', array('Approved', 'Disapproved'));
            $table->string('cvf_no');
 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
