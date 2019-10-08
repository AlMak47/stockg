<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    //

    protected $table = 'commande';

    protected $keyType = 'string';
    protected $primaryKey = 'code';

    public function items() {
      return $this->hasMany('App\Sortis','code_commande','code');
    }
}
