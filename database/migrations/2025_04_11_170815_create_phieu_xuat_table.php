<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhieuXuatTable extends Migration
{
    public function up()
    {
        Schema::create('phieu_xuat', function (Blueprint $table) {
            $table->string('ma_phieu_xuat', 15)->primary();
            $table->dateTime('ngay_xuat');
            $table->string('ma_kho', 12);
            $table->string('ma_sp', 8);
            $table->integer('so_luong_xuat');
            $table->string('ma_nv', 15);
            $table->foreign('ma_kho')->references('ma_kho')->on('kho_hang')->onDelete('cascade');
            $table->foreign('ma_sp')->references('ma_sp')->on('san_pham')->onDelete('cascade');
            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_vien')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phieu_xuat');
    }
}
