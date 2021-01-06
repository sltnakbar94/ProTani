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
            $table->text('site_address');
            $table->integer('pool_qty');
            $table->string('pool_large')->nullable();
            $table->string('fish_type')->nullable();
            $table->date('plant_date')->nullable();
            $table->date('harvest_date')->nullable();
            $table->integer('harvest_qty')->nullable();
            $table->string('sitepict1')->nullable();
            $table->string('sitepict3')->nullable();
            $table->string('sitepict2')->nullable();
            $table->string('sitepict4')->nullable();
            $table->string('sitepict5')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->text('description')->nullable();
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
