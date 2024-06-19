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
        Schema::create('student_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('available_country_id');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->date('dob')->nullable();
            $table->enum('marital_status',['married','unmarried','divorced','widowed'])->nullable();
            $table->text('notes_for_counsellor')->nullable();
            $table->timestamps();
        });

        Schema::table('student_details',function($table){
            $table->foreign('available_country_id')->references('id')->on('available_countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_details');
    }
};
