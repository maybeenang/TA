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
        Schema::create('fakultas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('program_studis', function (Blueprint $table) {
            $table->foreignUuid('fakultas_id')->constrained('fakultas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_studis', function (Blueprint $table) {
            $table->dropForeign(['fakultas_id']);
        });
        Schema::dropIfExists('fakultas');
    }
};
