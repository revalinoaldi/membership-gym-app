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
            $table->string('kode_member');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->enum('jenis_kelamin',['Laki-Laki', 'Perempuan']);
            $table->string('alamat');
            $table->string('no_telp');
            $table->dateTime('tgl_daftar');
            $table->enum('status',['ACTIVE', 'NON ACTIVE']);
            $table->string('token');
            $table->date('expired_date');
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
