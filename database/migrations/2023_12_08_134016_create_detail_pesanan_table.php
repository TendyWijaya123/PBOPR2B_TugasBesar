<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPesananTable extends Migration
{
    public function up()
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPesanan');
            $table->unsignedBigInteger('idMakanan');
            $table->decimal('hargasatuan', 10, 2);
            $table->integer('jumlah');
            $table->decimal('total', 10, 2);
            $table->timestamps();

            $table->foreign('idPesanan')->references('idPesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('idMakanan')->references('idMakanan')->on('makanan');

            // Anda bisa menambahkan foreign key lainnya jika diperlukan
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_pesanan');
    }
}
