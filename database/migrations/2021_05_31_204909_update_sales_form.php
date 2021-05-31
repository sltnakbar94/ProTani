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
        Schema::table('sales_form', function(Blueprint $table) {
            $table->date('form_date');
            $table->string('pool_id');          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_form_details', function(Blueprint $table) {
            $table->date('form_date');
            $table->date('pool_id');           
        });
    }
}
