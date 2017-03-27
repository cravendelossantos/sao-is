<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('violation_id');
            $table->date('date');
            $table->integer('no_of_days');
            $table->integer('required_hours');
            $table->enum('status', array('On going', 'Completed'));
            $table->string('student_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('community_services');
    }
}
