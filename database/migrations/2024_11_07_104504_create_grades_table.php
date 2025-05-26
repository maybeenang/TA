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
        Schema::create('grades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->foreignUuid('report_id')->nullable()->constrained('reports')->cascadeOnDelete();
            $table->string('letter')->nullable();
            $table->decimal('total_score', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('grade_components', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('report_id')->constrained('reports')->cascadeOnDelete();
            $table->string('name');
            $table->decimal('weight', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('student_grades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('grade_component_id')->constrained('grade_components')->cascadeOnDelete();
            $table->foreignUuid('grade_id')->constrained('grades')->cascadeOnDelete();
            $table->decimal('score', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('grading_scale', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('report_id')->constrained('reports')->cascadeOnDelete();
            $table->string('letter');
            $table->decimal('score', 5, 2)->default(0);
            $table->integer('max_score')->default(0);
            $table->integer('min_score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
        Schema::dropIfExists('grade_components');
        Schema::dropIfExists('student_grades');
        Schema::dropIfExists('grading_scale');
    }
};
