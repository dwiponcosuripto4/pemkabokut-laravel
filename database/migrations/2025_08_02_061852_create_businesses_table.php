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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama', 255);
            $table->enum('jenis', [
                'Makanan dan Minuman',
                'Pakaian dan Aksesoris', 
                'Jasa',
                'Kerajinan Tangan',
                'Elektronik',
                'Kesehatan',
                'Transportasi',
                'Pendidikan',
                'Teknologi'
            ]);
            $table->string('owner', 255);
            $table->text('input_url')->nullable();
            $table->string('alamat')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('nomor_telepon', 15);
            $table->string('email', 255);
            $table->string('nib', 50);
            $table->text('deskripsi');
            $table->string('foto')->nullable(); // untuk menyimpan path gambar sebagai string
            $table->tinyInteger('status')->default(0)->comment('0 untuk pending, 1 untuk approved');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
