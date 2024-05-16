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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_exam');
            $table->string('payment_amount');
            $table->datetime('payment_time');
            $table->uuid('vnp_TxnRef');
            $table->timestamps();

            $table->foreign('id_user')
                ->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_exam')
                ->references('id')->on('exams')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
