<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiTietCuaHangTable extends Migration
{
    public function up()
    {
        Schema::create('chi_tiet_cua_hang', function (Blueprint $table) {
            $table->string('ma_cua_hang', 10);
            $table->string('ma_sp', 8);
            $table->integer('so_luong')->default(0);
            $table->primary(['ma_cua_hang', 'ma_sp']);
            $table->foreign('ma_cua_hang')->references('ma_cua_hang')->on('cua_hang')->onDelete('cascade');
            $table->foreign('ma_sp')->references('ma_sp')->on('san_pham')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chi_tiet_cua_hang');
    }
}