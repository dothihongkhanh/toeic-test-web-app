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
        Schema::create('image_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_image')->nullable();
            $table->unsignedBigInteger('id_question')->nullable();
            $table->timestamps();

            $table->foreign('id_image')
                ->references('id')->on('images')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_question')
                ->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_questions');
    }
};
