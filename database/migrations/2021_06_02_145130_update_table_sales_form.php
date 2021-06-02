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
            $table->date('survey_date');
            $table->string('rt_rw_pool');
            $table->string('pool_province_id');
            $table->string('pool_regency_id');
            $table->string('pool_district_id');
            $table->string('pool_village_id');
            $table->string('pokdakan_name');
            $table->string('position_in_organization');
            $table->integer('lenght_effort');
            $table->string('fish_type');
            $table->string('pool_area');
            $table->string('pool_type');
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
        Schema::table('sales_forms', function(Blueprint $table) {
            $table->date('survey_date');
            $table->string('rt_rw_pool');
            $table->string('pool_province_id');
            $table->string('pool_regency_id');
            $table->string('pool_district_id');
            $table->string('pool_village_id');
            $table->string('pokdakan_name');
            $table->string('position_in_organization');
            $table->integer('lenght_effort');
            $table->string('fish_type');
            $table->string('pool_area');
            $table->string('pool_type');
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
}
