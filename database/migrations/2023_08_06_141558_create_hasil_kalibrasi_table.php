<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kalibrasi_hasil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_kalibrasi");
            $table->unsignedBigInteger('id_sensor');
            $table->double('modus')->default(0);
            $table->double('a')->default(0);
            $table->double('b')->default(0);

            $table->foreign("id_kalibrasi")->references("id")->on("kalibrasi_data")->onDelete("cascade");
            $table->foreign('id_sensor')->references('id')->on('sensor_jenis')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_kalibrasi');
    }
};
