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
        Schema::create('interventions', function (Blueprint $table) {
            $table->string('CODE_INTER', 30)->primary()->unique();
            $table->string('raison');
            $table->string('actions',512);
            $table->integer('duree');
            $table->date('date');
            $table->unsignedBigInteger('user_id');
            $table->string('ref_machine', 30);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ref_machine')->references('ref_machine')->on('machines');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interventions');
    }
};
