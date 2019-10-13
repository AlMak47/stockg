<?php

namespace App\Imports;

use App\Produits;
use Maatwebsite\Excel\Concerns\ToModel;

class ProduitsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Produits([
            //
            'reference' =>  'IT'.time(),
            'libelle' =>  $row[0],
            'prix_unitaire' =>  $row[1],
            'prix_achat'  =>  $row[2],
            'quantite' =>  $row[3],
            'image' =>  'null'
        ]);
    }
}
