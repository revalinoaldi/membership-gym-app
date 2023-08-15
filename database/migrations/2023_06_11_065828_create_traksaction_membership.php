<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_memberships', function (Blueprint $table) {
            $table->uuid('uid')->default(DB::raw('(UUID())'))->primary();
            $table->string('kode_transaksi', 27)->unique();
            $table->unsignedBigInteger('membership_id');
            $table->unsignedBigInteger('paket_id');
            $table->dateTime('tgl_transaksi');
            $table->double('total_biaya');
            $table->json('remark')->nullable();
            $table->string('payment_url', 191)->nullable();
            $table->enum('paid_status', [0,1])->default(0);
            $table->dateTime('paid_date')->nullable();
            $table->dateTime('expired_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('membership_id')->references('id')->on('memberships');
            $table->foreign('paket_id')->references('id')->on('pakets');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_membership');
    }
};
