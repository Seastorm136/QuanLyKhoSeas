<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhieuNhapCuaHangTable extends Migration
{
    public function up()
    {
        Schema::create('phieu_nhap_cua_hang', function (Blueprint $table) {
            $table->string('ma_phieu_nhap_ch', 15)->primary();
            $table->dateTime('ngay_nhap');
            $table->string('ma_cua_hang', 10);
            $table->string('ma_sp', 8);
            $table->integer('so_luong_nhap');
            $table->string('ma_nv', 15);
            $table->foreign('ma_cua_hang')->references('ma_cua_hang')->on('cua_hang')->onDelete('cascade');
            $table->foreign('ma_sp')->references('ma_sp')->on('san_pham')->onDelete('cascade');
            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_vien')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phieu_nhap_cua_hang');
    }
}