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
        Schema::create('machines', function (Blueprint $table) {
            $table->string('ref_machine', 30)->primary()->unique();
            $table->string('name_machine');
            $table->string('discipline_machine');
            $table->string('fonction_machine');
            $table->date('date_entree');
            $table->date('date_sortie')->nullable();
            $table->string('accessoires_machine');
            $table->string('image_machine')->nullable();
            $table->boolean('status')->default(0);
            $table->string('logo_client')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('fournissur_id');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('fournissur_id')->references('id')->on('founissors');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machines');
    }
};
