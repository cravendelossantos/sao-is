<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_messages', function (Blueprint $table) {
            $table->increments('message_id');
            $table->timestamps();
            $table->string('recipient');
            $table->longText('message');
            $table->enum('type', array('Manual', 'Violation Notification', 'Community Service Notification', 'Suspension Notification'));
            $table->boolean('sent');
            $table->date('date_sent');
            $table->time('time_sent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('text_messages');
    }
}
