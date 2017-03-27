<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplainantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complainants', function (Blueprint $table) {
            $table->string('id_no')->primary()->index();
            $table->string('name');
            $table->enum('position', array('Guard', 'Faculty', 'Student'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('complainants');
    }
}
