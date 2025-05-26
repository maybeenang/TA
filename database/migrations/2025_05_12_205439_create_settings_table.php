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
        Schema::create('settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key');
            $table->string('name');
            $table->boolean('is_shown')->default(true);
            $table->foreignUuid('program_studi_id')->constrained('program_studis')->onDelete('cascade');
            $table->foreignId('last_updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('last_synced_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('last_updated_at')->nullable();
            $table->dateTime('last_synced_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
