<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhieuChuyenKhoTable extends Migration
{
    public function up()
    {
        Schema::create('phieu_chuyen_kho', function (Blueprint $table) {
            $table->string('ma_phieu_chuyen', 16)->primary();
            $table->dateTime('ngay_chuyen');
            $table->string('ma_kho_nguon', 12);
            $table->string('ma_kho_dich', 12);
            $table->string('ma_sp', 8);
            $table->integer('so_luong_chuyen_den')->default(0);
            $table->integer('so_luong_chuyen_di')->default(0);
            $table->string('ma_nv', 15);
            $table->foreign('ma_kho_nguon')->references('ma_kho')->on('kho_hang')->onDelete('cascade');
            $table->foreign('ma_kho_dich')->references('ma_kho')->on('kho_hang')->onDelete('cascade');
            $table->foreign('ma_sp')->references('ma_sp')->on('san_pham')->onDelete('cascade');
            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_vien')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phieu_chuyen_kho');
    }
}