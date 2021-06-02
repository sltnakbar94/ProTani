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
            $table->date('pokdakan_name')->nullable();
            $table->string('position_in_organization')->nullable();
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
        Schema::table('sales_form_details', function(Blueprint $table) {
            $table->date('pokdakan_name')->nullable();
            $table->string('position_in_organization')->nullable();      
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
