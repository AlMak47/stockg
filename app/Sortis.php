<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sortis extends Model
{
    //
    protected $table = 'sorti_produit';

    public function command() {
      return Command::where('code',$this->code_commande)->first();
    }

    public function produits() {
      return Produits::where('reference',$this->produit)->first();
    }
}
