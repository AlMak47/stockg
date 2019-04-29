<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('produits',function(Blueprint $table) {
            $table->string('reference',255);
            $table->primary('reference');
            $table->string('libelle',255)->unique();
            $table->string('image');
            $table->float('prix_unitaire');
            $table->float('prix_achat');
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
        Schema::dropIfExists('produits');
    }
}
