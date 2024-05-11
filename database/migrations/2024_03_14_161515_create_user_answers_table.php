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
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user_exam');
            $table->unsignedBigInteger('id_user_answer');
            $table->timestamps();

            $table->foreign('id_user_exam')
                ->references('id')->on('user_exams')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user_answer')
                ->references('id')->on('answers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};
