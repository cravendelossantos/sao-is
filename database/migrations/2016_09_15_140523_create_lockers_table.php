<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLockersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lockers', function (Blueprint $table) {
            $table->increments('locker_no');
            $table->string('lessee_name')->nullable();
            $table->string('lessee_id')->nullable();
            $table->enum('status', array('Available', 'Occupied', 'Damaged', 'Locked'));
            $table->date('start_of_contract');
            $table->date('end_of_contract');
            $table->integer('location_id');
            $table->date('date_created');
            $table->integer('added_by');
            $table->integer('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lockers');
    }
}
