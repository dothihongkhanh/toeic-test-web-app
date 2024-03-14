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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_part');
            $table->unsignedBigInteger('id_level');
            $table->string('question_title')->nullable();
            $table->unsignedBigInteger('id_image')->nullable();
            $table->unsignedBigInteger('id_audio')->nullable();
            $table->timestamps();

            $table->foreign('id_part')
                ->references('id')->on('parts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_level')
                ->references('id')->on('levels')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_image')
                ->references('id')->on('images')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_audio')
                ->references('id')->on('audios')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
