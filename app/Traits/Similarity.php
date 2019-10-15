<?php

namespace App\Traits;
use App\Boutique;
use App\User;
use App\Produits;
use App\Stockage;
use App\Sortis;
use Carbon\Carbon;
use App\Entree;
trait Similarity {

	    public function addEntree ($produit,$boutique,$quantite) {
	        $entree = new Entree;
	        $entree->produit = $produit;
	        $entree->boutique = $boutique;
	        $entree->quantite = $quantite;
	        $entree->save();
	    }


	    public function isInStock($reference,$boutique) {
	        $tmp = Stockage::select()->where([
	            ['produit',$reference],
	            ['boutiques',$boutique]
	        ])->first();
	        if(is_null($tmp)) {
	            return false;
	        }
	        return true;
	    }

	    //Determinier si le produit est nouveau ou ancier
	    public function isNewItem($libelle) {
	        $tmp = Produits::select()->where('libelle',$libelle)->first();
	        if(is_null($tmp)) {
	            // le produit n'existe pas
	            return true;
	        }
	        return false;
	    }

	public function organize($tab,$quantite,$option=true) {
        $test = [
                'reference' => $tab->reference,
                'libelle' => $tab->libelle,
                'prix_achat' => number_format($tab->prix_achat),
                'prix_unitaire' => number_format($tab->prix_unitaire),
                'quantite' => $quantite,
                'photo' =>$tab->image
            ] ;
            if(!$option) {
            array_forget($test,'prix_achat');
        }
            return $test;
    }

    public function getItemByLocalisation($ref,$options=true) {
            $filterItemInfos = [];
            // traitement filter ajax
            $localisation = $ref;
            $filterItem = Stockage::select()->where('boutiques',$ref)->get();
            foreach($filterItem as $key => $values) {
                $tmp = Produits::select()->where('reference',$values->produit)->first();
                if($options) {
                $filterItemInfos[$key] = $this->organize($tmp,$values->quantite);
                } else {
                    $filterItemInfos[$key] = $this->organize($tmp,$values->quantite,false);
                }
            }

            return $filterItemInfos;
    }

    public function totalCashCommand($command) {
        $sorti = Sortis::select()->where('code_commande',$command)->get();
        $total = 0;
        if($sorti->count() > 0) {
            foreach($sorti as $key => $values) {
                $prixIndividuel = 0;
                $item = Produits::select()->where('reference',$values->produit)->first();
                $prixIndividuel= $item->prix_unitaire * $values->quantite_commande;
                $total+=$prixIndividuel;
            }
        }
            return $total;

    }

    public function interetCommand($command) {
        $sorti = Sortis::select()->where('code_commande',$command)->get();
        $totalInteret = 0;
        if($sorti->count() > 0) {
            foreach($sorti as $key => $values) {
                // $prixIndividuel = 0;
                $interet = 0;
                $item = Produits::select()->where('reference',$values->produit)->first();
                // $prixIndividuel= $item->prix_unitaire * $values->quantite_commande;
                $interet = ($item->prix_unitaire - $item->prix_achat) * $values->quantite_commande;
                $totalInteret+=$interet;
            }
        }

        return $totalInteret;
    }

    public function organizeCommand($commande,$option=true) {
        $all =[];

        foreach($commande as $key => $values) {
            $total = $this->totalCashCommand($values->code);
            $date = new Carbon($values->updated_at);
            $all[$key]=[
                'code_command'=>$values->code,
                'boutique'=>$values->boutique,
                'date'=>$date->toFormattedDateString(),
                'status'=>$values->status,
                'cash'=>number_format($total)
            ];
                if(!$option){
                array_forget($all[$key],'boutique');
            }
        }

        return $all;
    }

    // recuperation des produits par commande
    public function getItemByCommand($command) {
        $sorti = Sortis::select()->where('code_commande',$command)->get();
        if($sorti->count() > 0) {
            // Les produits existent
            return $sorti;
        }
        return false;
    }

    public function dateOfDay() {
        $date = new Carbon;
        // dd($date);
        return $date->toFormattedDateString();
    }

    public function isValidCommand($command) {
        if($this->getItemByCommand($command)) {
            // la command est valide
            return true;
        }
        return false;
    }

    // public function itemsCommand($codeCommande) {
    //     $items = Sorits::select()->where('code_commande',$codeCommande);

    // }

    public function getItemInfo($item) {
        $infos = Produits::select()->where('reference',$item)->first();
        if($infos) {
            return $infos;
        }
        return false;
    }

    public function getDetailsCommand($items) {
        if($items) {
            foreach($items as $key => $values) {
            $other = $this->getItemInfo($values->produit);
            $total = $other->prix_unitaire * $values->quantite_commande;
            $all[$key] = [
                'reference'=> $values->produit,
                'designation'=> $other->libelle,
                'prix_unitaire'=>number_format($other->prix_unitaire),
                'quantite_command'=>$values->quantite_commande,
                'total'=> number_format($total)

            ];

            }
        return $all;
        }

    }

  // verifier si le nom du produit existe en bdd
  public function isExistItem($name) {
    $item = Produits::select()->where('libelle',$name)->first();
    if($item) {
        return $item;
    }
    return false;
  }
}
