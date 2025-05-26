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
            $table->uuid('id')->primary();

            $table->string('path');
            $table->string('name');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->foreignUuid('signature_gkmp_id')->nullable()->constrained('signatures')->cascadeOnDelete()->after('pdf_status');
            $table->foreignUuid('signature_kaprodi_id')->nullable()->constrained('signatures')->cascadeOnDelete()->after('pdf_status');
            // verified
            $table->foreignId('verifikator_gkmp')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('verifikator_kaprodi')->nullable()->constrained('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signatures');
        Schema::table('reports', function (Blueprint $table) {

            $table->dropForeign(['signature_gkmp_id']);
            $table->dropColumn('signature_gkmp_id');

            $table->dropForeign(['signature_kaprodi_id']);
            $table->dropColumn('signature_kaprodi_id');

            $table->dropForeign(['verifikator_gkmp']);
            $table->dropColumn('verifikator_gkmp');

            $table->dropForeign(['verifikator_kaprodi']);
            $table->dropColumn('verifikator_kaprodi');
        });
    }
};
