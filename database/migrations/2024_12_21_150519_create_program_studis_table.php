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
        Schema::create('program_studis', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studis');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['program_studi_id']);
            $table->dropColumn('program_studi_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['program_studi_id']);
            $table->dropColumn('program_studi_id');
        });
        Schema::dropIfExists('program_studis');
    }
};
