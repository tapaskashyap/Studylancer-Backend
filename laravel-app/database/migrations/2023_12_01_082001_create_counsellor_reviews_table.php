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
        Schema::create('counsellor_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counsellor_detail_id');
            $table->string('review')->nullable();
            $table->decimal('rating',2,1);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
        Schema::table('counsellor_reviews',function($table){
            $table->foreign('counsellor_detail_id')->references('id')->on('counsellor_details')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counsellor_reviews');
    }
};
