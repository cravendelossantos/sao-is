<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViolationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('description');
            $table->enum('offense_level', array('Less Serious', 'Serious', 'Very Serious'));
        
            $table->string('first_offense_sanction');
            $table->string('second_offense_sanction');
            $table->string('third_offense_sanction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('violations');
    }
}
