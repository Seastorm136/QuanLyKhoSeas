<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuaHangTable extends Migration
{
    public function up()
    {
        Schema::create('cua_hang', function (Blueprint $table) {
            $table->string('ma_cua_hang', 10)->primary();
            $table->string('ten_cua_hang', 30);
            $table->string('ma_nv', 15);
            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_vien')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cua_hang');
    }
}