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
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_exam');
            $table->unsignedBigInteger('id_question');
            $table->timestamps();

            $table->foreign('id_exam')
                ->references('id')->on('exams')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_question')
                ->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
