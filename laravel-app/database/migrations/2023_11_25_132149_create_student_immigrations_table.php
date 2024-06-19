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
        Schema::create('student_immigrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_detail_id');
            $table->unsignedBigInteger('country_id');
            $table->string('visa_type');
            $table->string('visa_outcome');
            $table->string('year');
            $table->timestamps();
        });
        Schema::table('student_immigrations',function($table){
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('student_detail_id')->references('id')->on('student_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_immigrations');
    }
};
