<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    //
    protected $table = 'produits';
    protected $keyType = 'string';
    protected $primaryKey = 'reference';

    public function sortis() {
      return $this->hasMany("App\Sortis");
    }

}
