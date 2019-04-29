<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('entree',function(Blueprint $table) {
            $table->increments('code');
            $table->string('produit',255);
            $table->string('boutique',255);
            $table->unsignedInteger('quantite')->default(0);
            $table->timestamps();
            $table->foreign('boutique')->references('localisation')->on('boutique');
            $table->foreign('produit')->references('reference')->on('produits');
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
        Schema::dropIfExists('entree');
    }
}
