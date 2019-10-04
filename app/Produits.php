<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    //
    protected $table = 'produits';
    protected $keyType = 'string';
    protected $primaryKey = 'reference';

    // public function stockage() {
    // 	return $this->hasOne('App\Stockage','produit','reference');
    // }

    // public function boutique() {
    // 	return $this->hasMany('App\Boutique','boutiques');
    // }
}
