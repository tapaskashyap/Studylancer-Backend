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
        Schema::create('counsellor_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('available_country_id');
            $table->string('working_since')->nullable();
            $table->string('students_helped')->nullable();
            $table->text('about_me')->nullable();
            $table->string('counselling_fee')->nullable();
            $table->timestamps();
        });

        Schema::table('counsellor_details',function($table){
            $table->foreign('available_country_id')->references('id')->on('available_countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counsellor_details');
    }
};
