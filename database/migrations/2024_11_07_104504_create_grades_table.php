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
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->foreignId('report_id')->nullable()->constrained('reports')->cascadeOnDelete();
            $table->string('letter')->nullable();
            $table->decimal('total_score', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('grade_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->string('name');
            $table->decimal('weight', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_component_id')->constrained('grade_components')->cascadeOnDelete();
            $table->foreignId('grade_id')->constrained('grades')->cascadeOnDelete();
            $table->decimal('score', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('grading_scale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
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
