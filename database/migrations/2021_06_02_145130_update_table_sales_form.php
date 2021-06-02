<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableSalesForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_forms', function(Blueprint $table) { 
            $table->string('surveyor_id')->nullable();
            $table->integer('surveyor_phone_number')->nullable();
            $table->date('survey_date')->nullable();
            $table->string('rt_pool')->nullable();
            $table->string('rw_pool')->nullable();
            $table->string('pool_province_id')->nullable();
            $table->string('pool_regency_id')->nullable();
            $table->string('pool_district_id')->nullable();
            $table->string('pool_village_id')->nullable();
            $table->string('pokdakan_name')->nullable();
            $table->string('position_in_organization')->nullable();
            $table->integer('lenght_effort')->nullable();
            $table->string('fish_type')->nullable();
            $table->string('pool_area')->nullable();
            $table->string('pool_type')->nullable();
            $table->string('yields')->nullable();
            $table->string('fish_food_type')->nullable();
            $table->string('fish_food_brand')->nullable();
            $table->string('fish_food_price')->nullable();
            $table->string('fish_food_needs')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('fish_food_retrieval_system')->nullable();
            $table->string('source_fund')->nullable();
            $table->string('fish_seed_source')->nullable();
            $table->string('fish_mantaince_period')->nullable();
            $table->string('harvest_cost')->nullable();
            $table->string('harvest_method')->nullable();        
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
            $table->string('surveyor_id')->nullable();
            $table->integer('surveyor_phone_number')->nullable();
            $table->date('survey_date')->nullable();
            $table->string('rt_pool')->nullable();
            $table->string('rw_pool')->nullable();
            $table->string('pool_province_id')->nullable();
            $table->string('pool_regency_id')->nullable();
            $table->string('pool_district_id')->nullable();
            $table->string('pool_village_id')->nullable();
            $table->string('pokdakan_name')->nullable();
            $table->string('position_in_organization')->nullable();
            $table->integer('lenght_effort')->nullable();
            $table->string('fish_type')->nullable();
            $table->string('pool_area')->nullable();
            $table->string('pool_type')->nullable();
            $table->string('yields')->nullable();
            $table->string('fish_food_type')->nullable();
            $table->string('fish_food_brand')->nullable();
            $table->string('fish_food_price')->nullable();
            $table->string('fish_food_needs')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('fish_food_retrieval_system')->nullable();
            $table->string('source_fund')->nullable();
            $table->string('fish_seed_source')->nullable();
            $table->string('fish_mantaince_period')->nullable();
            $table->string('harvest_cost')->nullable();
            $table->string('harvest_method')->nullable();        
        });
    }
}
