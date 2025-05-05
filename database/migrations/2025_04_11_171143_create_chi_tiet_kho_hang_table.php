<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiTietKhoHangTable extends Migration
{
    public function up()
    {
        Schema::create('chi_tiet_kho_hang', function (Blueprint $table) {
            $table->string('ma_kho', 12);
            $table->string('ma_sp', 8);
            $table->integer('so_luong')->default(0);
            $table->primary(['ma_kho', 'ma_sp']);
            $table->string('ma_phieu_nhap', 15)->nullable();
            $table->string('ma_phieu_xuat', 15)->nullable();
            $table->string('ma_phieu_chuyen', 15)->nullable();
            $table->foreign('ma_kho')->references('ma_kho')->on('kho_hang')->onDelete('cascade');
            $table->foreign('ma_sp')->references('ma_sp')->on('san_pham')->onDelete('cascade');
            $table->foreign('ma_phieu_nhap')->references('ma_phieu_nhap')->on('phieu_nhap')->onDelete('set null');
            $table->foreign('ma_phieu_xuat')->references('ma_phieu_xuat')->on('phieu_xuat')->onDelete('set null');
            $table->foreign('ma_phieu_chuyen')->references('ma_phieu_chuyen')->on('phieu_chuyen_kho')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chi_tiet_kho_hang');
    }
}