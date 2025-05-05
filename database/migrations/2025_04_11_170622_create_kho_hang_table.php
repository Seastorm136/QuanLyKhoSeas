<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhoHangTable extends Migration
{
    public function up()
    {
        Schema::create('kho_hang', function (Blueprint $table) {
            $table->string('ma_kho', 12)->primary();
            $table->string('ten_kho', 30);
            $table->string('ma_nv', 15);
            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_vien')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kho_hang');
    }
}