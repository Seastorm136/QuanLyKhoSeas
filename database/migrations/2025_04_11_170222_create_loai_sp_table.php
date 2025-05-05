<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoaiSpTable extends Migration
{
    public function up(): void
    {
        Schema::create('loai_sp', function (Blueprint $table) {
            $table->string('loai_sp', 20)->primary();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loai_sp');
    }
};
