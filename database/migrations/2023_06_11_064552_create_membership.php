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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('kode_member', 9)->unique();
            $table->string('nama_lengkap', 50);
            $table->string('email', 75)->unique();
            $table->enum('jenis_kelamin',['Laki-Laki', 'Perempuan']);
            $table->string('alamat', 191)->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->dateTime('tgl_daftar')->nullable();
            $table->enum('status',['ACTIVE', 'NON ACTIVE'])-> default('NON ACTIVE');
            $table->string('token', 191)->nullable();
            $table->date('expired_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership');
    }
};
