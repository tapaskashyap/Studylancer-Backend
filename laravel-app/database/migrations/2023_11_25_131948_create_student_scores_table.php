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
        Schema::create('student_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_detail_id');
            $table->unsignedBigInteger('english_proficiency_test_id');
            $table->string('listening');
            $table->string('reading');
            $table->string('writing');
            $table->string('speaking');
            $table->string('total');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->timestamps();
        });
        Schema::table('student_scores',function($table){
            $table->foreign('student_detail_id')->references('id')->on('student_details')->onDelete('cascade');
            $table->foreign('english_proficiency_test_id')->references('id')->on('english_proficiency_tests')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_scores');
    }
};
