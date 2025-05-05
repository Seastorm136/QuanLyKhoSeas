<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLoginTable extends Migration
{
    public function up(): void
    {
        Schema::create('admin_login', function (Blueprint $table) {
            $table->string('admin_name', 30)->primary();
            $table->string('password', 255);
            $table->string('remember_token', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_login');
    }
};
