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
        Schema::create('counsellor_detail_timeslot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counsellor_detail_id');
            $table->unsignedBigInteger('time_slot_id');
        });
        Schema::table('counsellor_detail_timeslot',function($table){
            $table->foreign('counsellor_detail_id')->references('id')->on('counsellor_details')->onDelete('cascade');
            $table->foreign('time_slot_id')->references('id')->on('time_slots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counsellor_detail_timeslot');
    }
};
