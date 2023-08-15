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
        Schema::create('kunjungan_member', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kunjungan_id');
            $table->string('transaction_code', 14)->unique();
            $table->unsignedBigInteger('member_id');
            $table->time('checkin_time');
            $table->time('checkout_time')->nullable();
            $table->enum('status_kunjungan', ['0', '1'])->default('0');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('member_id')->references('id')->on('memberships');
            $table->foreign('kunjungan_id')->references('id')->on('kunjungan_dayin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan_member');
    }
};
