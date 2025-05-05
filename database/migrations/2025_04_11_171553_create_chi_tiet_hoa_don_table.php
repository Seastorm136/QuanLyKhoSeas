<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiTietHoaDonTable extends Migration
{
    public function up()
    {
        Schema::create('chi_tiet_hoa_don', function (Blueprint $table) {
            $table->string('ma_hoa_don');
            $table->string('ma_sp');
            $table->integer('so_luong');
            $table->decimal('don_gia', 15, 2);
            $table->decimal('thanh_tien', 15, 2);
            $table->timestamps();
            $table->primary(['ma_hoa_don', 'ma_sp']);
            $table->foreign('ma_hoa_don')->references('ma_hoa_don')->on('hoa_don')->onDelete('cascade');
            $table->foreign('ma_sp')->references('ma_sp')->on('san_pham')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chi_tiet_hoa_don');
    }
}