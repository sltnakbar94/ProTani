<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_forms', function (Blueprint $table) {
            $table->id();
            $table->string('farmer_name');
            $table->string('phone_number')->nullable();
            $table->string('id_number');
            $table->string('id_address');
            $table->integer('rt');
            $table->integer('rw');
            $table->string('villages');
            $table->string('districts');
            $table->string('regencies');
            $table->string('provinces');
            $table->string('idpict')->nullable();
            $table->text('site_address')->nullable();
            $table->integer('pool_qty')->nullable();
            $table->text('description')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('sales_forms');
    }
}
