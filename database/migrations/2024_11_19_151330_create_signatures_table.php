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
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();

            $table->string('path');
            $table->string('name');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->foreignId('signature_id')->nullable()->constrained('signatures')->cascadeOnDelete()->after('pdf_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signatures');
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['signature_id']);
            $table->dropColumn('signature_id');
        });
    }
};
