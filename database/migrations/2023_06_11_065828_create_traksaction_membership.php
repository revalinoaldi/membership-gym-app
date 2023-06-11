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
        Schema::create('transaction_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->unsigned();
            $table->foreignId('paket_id')->unsigned();
            $table->dateTime('tgl_transaksi');
            $table->double('total_biaya');
            $table->json('remark')->nullable();
            $table->string('payment_url')->nullable();
            $table->enum('paid_status', [0,1])->default(0);
            $table->dateTime('paid_date')->nullable();
            $table->dateTime('expired_date')->nullable();
            $table->foreignId('user_id');
            $table->timestamps();
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
