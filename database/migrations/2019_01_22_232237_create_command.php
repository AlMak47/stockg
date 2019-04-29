<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('commande',function(Blueprint $table) {
            $table->string('code',255);
            $table->primary('code');
            $table->string('boutique',255);
            $table->foreign('boutique')->references('localisation')->on('boutique');
            $table->enum('status',['attente','confirme'])->default('attente');
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
        //
        Schema::dropIfExists('commande');
    }
}
