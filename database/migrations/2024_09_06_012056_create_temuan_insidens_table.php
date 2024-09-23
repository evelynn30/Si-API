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
        Schema::create('temuan_insiden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('temuan_id')->constrained(
                table:'temuan'
            );
            $table->foreignId('insiden_id')->constrained(
                table:'insiden'
            );
        
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
        Schema::dropIfExists('temuan_insiden');
    }
};