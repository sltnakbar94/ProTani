<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('nomor_order');
            $table->string('tujuan');
            $table->unsignedBigInteger('qty');
            $table->string('url')->nullable();
            $table->string('status_order')->default(1);
            $table->unsignedBigInteger('jumlah_diterima')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('hp_penerima')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('status_terima')->default(0);
            $table->datetime('tanggal_terima')->nullable();
            $table->string('status_scan')->default(0);
            $table->uuid('user_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('order_details');
    }
}
