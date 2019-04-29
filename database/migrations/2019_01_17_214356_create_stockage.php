<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('stockage',function (Blueprint $table) {
            $table->string('produit');
            $table->string('boutiques');
            $table->primary(['produit','boutiques']);
            $table->unsignedInteger('quantite')->default(0);
            $table->foreign('boutiques')->references('localisation')->on('boutique');
            $table->foreign('produit')->references('reference')->on('produits');
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
        Schema::dropIfExists('stockage');
    }
}
