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
        Schema::create('inter_piece', function (Blueprint $table) {
            $table->id();
            $table->string('CODE_INTER', 30);
            $table->string('SN', 30);
            $table->timestamps();

            $table->foreign('CODE_INTER')->references('CODE_INTER')->on('interventions');
            $table->foreign('SN')->references('SN')->on('pieces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inter_piece');
    }
};
