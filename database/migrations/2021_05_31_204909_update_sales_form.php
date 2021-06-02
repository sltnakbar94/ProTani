<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSalesForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_forms', function(Blueprint $table) {
            $table->date('form_date')->nullable();
            $table->string('pool_id')->nullable();          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_forms', function(Blueprint $table) {
            $table->date('form_date')->nullable();
            $table->date('pool_id')->nullable();           
        });
    }
}
