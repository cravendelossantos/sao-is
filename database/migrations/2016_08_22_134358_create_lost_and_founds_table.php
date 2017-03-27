<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLostAndFoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lost_and_founds', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_reported');
            $table->time('time_reported');
            $table->string('school_year');
			$table->string('item_description');
            $table->string('distinctive_marks');
            //brand?
			$table->string('endorser_name');
			$table->string('found_at');
			$table->string('owner_name');
            $table->string('claimer_name');
			$table->date('date_claimed');
			$table->enum('status', array('Unclaimed','Claimed','Donated'));
			$table->date('disposal_date');
			$table->integer('reporter_id');
            $table->integer('claimed_reporter_id');
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lost_and_founds');
    }
}
