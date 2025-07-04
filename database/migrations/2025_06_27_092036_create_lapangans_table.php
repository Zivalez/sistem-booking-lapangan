<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lapangan');
            $table->string('jenis');
            $table->integer('harga_per_jam');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};