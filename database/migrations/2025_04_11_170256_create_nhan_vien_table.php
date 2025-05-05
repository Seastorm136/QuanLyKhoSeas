<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhanVienTable extends Migration
{
    public function up(): void
    {
        Schema::create('nhan_vien', function (Blueprint $table) {
            $table->string('ma_nv', 15)->primary();
            $table->string('ten_nv', 20);
            $table->enum('gioitinh', ['Nam', 'Nữ']);
            $table->date('ngay_sinh');
            $table->string('so_dt', 10)->unique();
            $table->string('dia_chi', 100);
            $table->enum('chuc_vu', ['Nhân viên kho', 'Nhân viên bán hàng']);
            $table->string('ten_tknh', 50);
            $table->string('so_tknh', 10)->unique();
            $table->string('ten_dn', 30)->unique();
            $table->foreign('ten_dn')->references('staff_name')->on('staff_login')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nhan_vien');
    }
};
