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
        Schema::create('question_child', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_question');
            $table->string('question_number');
            $table->string('question_title')->nullable();
            $table->text('explanation');
            $table->timestamps();

            $table->foreign('id_question')
                ->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_childs');
    }
};
