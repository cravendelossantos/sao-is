<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('school_year');
            $table->string('organization');
            $table->date('deadline');
            $table->boolean('requirement1');
            $table->boolean('requirement2');
            $table->boolean('requirement3');
            $table->boolean('requirement4');
            $table->boolean('requirement5');
            $table->boolean('requirement6');
            $table->boolean('requirement7');
            $table->boolean('requirement8');
            $table->boolean('requirement9');
            $table->integer('requirement10');
            $table->string('requirement11');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('requirements');
    }
}
