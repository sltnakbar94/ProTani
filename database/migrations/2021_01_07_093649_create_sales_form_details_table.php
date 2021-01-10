<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesFormDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_form_details', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_form_id');
            $table->integer('pool_number');
            $table->bigInteger('pool_large');
            $table->string('fish_type')->nullable();
            $table->date('plant_date')->nullable();
            $table->date('harvest_date')->nullable();
            $table->integer('harvest_qty')->nullable();
            $table->string('sitepict')->nullable();
            $table->string('result')->nullable();
            $table->string('status')->nullable()->default('0');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('user_id');
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
        Schema::dropIfExists('sales_form_details');
    }
}
