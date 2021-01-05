<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipients', function (Blueprint $table) {
            $table->unsignedBigInteger('regency_id')->after('lat')->nullable();
            $table->unsignedBigInteger('district_id')->after('lat')->nullable();
            $table->unsignedBigInteger('village_id')->after('lat')->nullable();
            $table->text('alamat')->after('lat')->nullable();
            $table->string('kode_pos')->after('lat')->nullable();
            $table->string('rw')->after('lat')->nullable();
            $table->string('rt')->after('lat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipients', function (Blueprint $table) {
            $table->dropColumn([
                'alamat',
                'regency_id',
                'district_id',
                'village_id',
                'rt',
                'rw',
                'kode_pos',
            ]);
        });
    }
}
