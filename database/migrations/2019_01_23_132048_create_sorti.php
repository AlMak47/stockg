<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSorti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sorti_produit',function (Blueprint $table) {
            $table->string('code_commande',255);
            $table->string('produit',255);
            $table->primary(['code_commande','produit']);
            $table->foreign('code_commande')->references('code')->on('commande');
            $table->foreign('produit')->references('reference')->on('produits');
            $table->unsignedInteger('quantite_commande');
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
        Schema::dropIfExists('sorti_produit');
    }
}
