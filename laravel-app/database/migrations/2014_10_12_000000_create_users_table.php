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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->unsignedBigInteger('country_id');
            $table->string('phone')->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('details_type')->nullable();
            $table->unsignedBigInteger('details_id')->nullable();
            $table->unsignedBigInteger('profile_status_id')->default(1);
            $table->integer('review_count')->default(0);
            $table->decimal('review_rating',2,1)->default(0.0);
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::table('users',function($table){
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('profile_status_id')->references('id')->on('profile_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
