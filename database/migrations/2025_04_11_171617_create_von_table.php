<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVonTable extends Migration
{
    public function up()
    {
        Schema::create('von', function (Blueprint $table) {
            $table->id();
            $table->string('ma_kho', 12)->unique();
            $table->decimal('tong_von', 15, 2)->default(0);
            $table->dateTime('ngay_cap_nhat')->nullable();
            $table->timestamps();
            $table->foreign('ma_kho')->references('ma_kho')->on('kho_hang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('von');
    }
}