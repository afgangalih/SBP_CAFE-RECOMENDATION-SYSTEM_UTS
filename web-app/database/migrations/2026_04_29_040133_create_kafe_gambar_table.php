<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kafe_gambar', function (Blueprint $table) {
            $table->id('id_gambar');
            $table->foreignId('id_kafe')->constrained('kafe', 'id_kafe')->onDelete('cascade');
            $table->string('path_gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kafe_gambar');
    }
};
