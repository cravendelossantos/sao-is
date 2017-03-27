<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViolationReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('violation_reports', function (Blueprint $table) {
            $table->string('rv_id')->index()->primary();
            $table->string('student_id');
            $table->integer('violation_id');
            $table->integer('offense_no');
            $table->string('sanction');
            $table->string('offense_level');
            $table->string('complainant_id');
            $table->enum('status' , array('Pending','On Going','Completed'));
            $table->date('date_reported');
            $table->time('time_reported');
            $table->string('school_year');
            $table->string('validity');
            $table->integer('reporter_id');
        });


        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('violation_reports');
    }
}
