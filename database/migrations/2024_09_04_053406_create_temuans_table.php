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
        Schema::create('temuan', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->foreignId('opd_id')->constrained(
                table: 'opd'
            );
            $table->foreignId('penemu_id')->constrained(
                table: 'penemu'
            );
            $table->text('url');
            $table->integer('status');
            $table->string('gambar');
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
        Schema::dropIfExists('temuan');
    }
};
