<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoaDonTable extends Migration
{
    public function up()
    {
        Schema::create('hoa_don', function (Blueprint $table) {
            $table->string('ma_hoa_don')->primary();
            $table->date('ngay_lap');
            $table->string('ma_nv');
            $table->decimal('tong_tien', 15, 2)->default(0);
            $table->timestamps();
            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_vien')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hoa_don');
    }
}