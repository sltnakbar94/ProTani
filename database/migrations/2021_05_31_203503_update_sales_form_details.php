<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSalesFormDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_form_details', function(Blueprint $table) {
            $table->date('pokdakan_name');
            $table->string('position_in_organization');
            $table->string('yields');
            $table->string('fish_food_type');
            $table->string('fish_food_brand');
            $table->string('fish_food_price');
            $table->string('fish_food_needs');
            $table->string('payment_method');
            $table->string('fish_food_retrieval_system');
            $table->string('source_fund');
            $table->string('fish_seed_source');
            $table->string('fish_mantaince_period');
            $table->string('harvest_cost');
            $table->string('harvest_method');

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
            $table->date('pokdakan_name');
            $table->string('position_in_organization');      
            $table->string('yields') ;
            $table->string('fish_food_type');
            $table->string('fish_food_brand');
            $table->string('fish_food_price');
            $table->string('fish_food_needs');
            $table->string('payment_method');
            $table->string('fish_food_retrieval_system');
            $table->string('source_fund');
            $table->string('fish_seed_source');
            $table->string('fish_mantaince_period');
            $table->string('harvest_cost');
            $table->string('harvest_method');
        });
    }
}
