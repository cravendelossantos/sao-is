<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->time('time_in');
            $table->time('time_out');
            $table->string('student_id');
            $table->integer('cs_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('time_logs');
    }
}
