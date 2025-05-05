<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVonLuuDongTable extends Migration
{
    public function up()
    {
        Schema::create('von_luu_dong', function (Blueprint $table) {
            $table->id();
            $table->decimal('tong_von_luu_dong', 15, 2)->default(0);
            $table->dateTime('ngay_cap_nhat')->nullable();
            $table->timestamps();
        });

        DB::table('von_luu_dong')->insert([
            'tong_von_luu_dong' => 0,
            'ngay_cap_nhat' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('von_luu_dong');
    }
}