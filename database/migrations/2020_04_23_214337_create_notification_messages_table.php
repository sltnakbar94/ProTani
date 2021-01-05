<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('to');
            $table->text('data')->nullable();
            $table->text('title');
            $table->text('body');
            $table->bigInteger('ttl')->default(0);
            $table->bigInteger('expiration')->default(0);
            $table->string('priority')->default('default');
            $table->text('subtitle')->nullable();
            // $table->text('sound')->default('default')->nullable();
            $table->integer('badge')->default(1);
            $table->text('channel_id')->nullable();
            $table->datetime('sent_at')->nullable();
            $table->datetime('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_messages');
    }
}
