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
        Schema::create('founissors', function (Blueprint $table) {
            $table->id();
            $table->string('name_founissor');
            $table->string('email_founissor');
            $table->string('telephone_founissor');
            $table->string('adresse_founissor');
            $table->string('logo_founissor')->nullable();
            $table->mediumText('description_founissor')->nullable();
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
        Schema::dropIfExists('founissors');
    }
};
