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
        Schema::create('counselling_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counsellor_detail_id');
            $table->unsignedBigInteger('student_detail_id');
            $table->unsignedBigInteger('time_slot_id');
            $table->unsignedBigInteger('weekday_id');
            $table->unsignedBigInteger('transaction_id');
            $table->date('date');
            $table->timestamps();
        });
        Schema::table('counselling_bookings',function($table){
            $table->foreign('counsellor_detail_id')->references('id')->on('counsellor_details')->onDelete('cascade');
            $table->foreign('student_detail_id')->references('id')->on('student_details')->onDelete('cascade');
            $table->foreign('time_slot_id')->references('id')->on('time_slots')->onDelete('cascade');
            $table->foreign('weekday_id')->references('id')->on('weekdays')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselling_bookings');
    }
};
