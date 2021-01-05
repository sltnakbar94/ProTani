<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('userable_id')->nullable();
            $table->string('userable_type')->nullable();
            $table->text('token');
            $table->text('data')->nullable();
            $table->boolean('active');
            $table->timestamps();
            $table->unique(['userable_id','userable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_users');
    }
}
