<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nomor');
            $table->foreignId('jenis_surat_masuk_id')->constrained(
                table: 'jenis_surat_masuk'
            );
            $table->foreignId('sifat_surat_id')->constrained(
                table: 'sifat_surat'
            );
            $table->foreignId('perihal_surat_id')->constrained(
                table: 'perihal_surat'
            );
            $table->boolean('is_attachment')->default(1);
            $table->boolean('is_reply')->default(0);
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_masuk');
    }
};
