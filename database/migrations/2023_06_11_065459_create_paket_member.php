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
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket', 100);
            $table->string('slug', 125);
            $table->double('harga');
            $table->string('deskripsi', 191);
            $table->integer('masa_aktif',false,true);
            $table->unsignedBigInteger('type_activation_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('type_activation_id')->references('id')->on('type_activations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
