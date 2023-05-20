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
        Schema::create('pieces', function (Blueprint $table) {
            $table->string('SN', 30)->primary()->unique();
            $table->string('designation');
            $table->string('description',255)->nullable();
            $table->string('ref_machine',30);
            $table->timestamps();

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
        Schema::dropIfExists('pieces');
    }
};
