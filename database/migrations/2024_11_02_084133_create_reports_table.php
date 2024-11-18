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

        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('nim');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('students_class_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('report_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->string('responsible_lecturer')->nullable();
            $table->longText('teaching_methods')->nullable();
            $table->longText('self_evaluation')->nullable();
            $table->longText('follow_up_plan')->nullable();
            $table->longText('note')->nullable();

            $table->foreignId('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->foreignId('report_status_id')->constrained('report_statuses')->cascadeOnDelete();
            $table->string('pdf_path')->nullable();
            $table->string('pdf_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('report_lecturers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->foreignId('lecturer_id')->constrained('lecturers')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('cpmks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->string('code')->nullable();
            $table->longtext('description')->nullable();
            $table->string('criteria')->nullable();
            $table->decimal('average_score', 5, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('quistionnaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->text('statement');
            $table->float('strongly_agree');
            $table->float('agree');
            $table->float('disagree');
            $table->float('strongly_disagree');
            $table->timestamps();
        });

        Schema::create('attendance_and_activity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->integer('week');
            $table->string('meeting_name');
            $table->integer('student_present')->nullable();
            $table->integer('student_active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('report_statuses');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('report_lecturers');
        Schema::dropIfExists('cpmks');
        Schema::dropIfExists('quistionnaires');
        Schema::dropIfExists('attendance_and_activity');
    }
};
