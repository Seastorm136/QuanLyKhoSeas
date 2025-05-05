<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanPhamTable extends Migration
{
    public function up(): void
    {
        Schema::create('san_pham', function (Blueprint $table) {
            $table->string('ma_sp', 8)->primary();
            $table->string('ten_sp', 50);
            $table->string('don_vi_tinh', 10);
            $table->decimal('gia_nhap', 15, 2);
            $table->decimal('ban_buon', 15, 2);
            $table->decimal('ban_le', 15, 2);
            $table->string('loai_sp', 20);
            $table->foreign('loai_sp')->references('loai_sp')->on('loai_sp')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('san_pham');
    }
};
