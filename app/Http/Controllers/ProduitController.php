<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BoutiqueRequest;
use App\Http\Requests\ProduitRequest;
use App\Boutique;
use App\User;
use App\Produits;
use App\Stockage;
use App\Traits\Similarity;
use App\Entree;
class ProduitController extends Controller
{

     use Similarity;
    //

    public function getImage($image) {

        if($image->isValid()) {
            $chemin=config('image.path');
            $extension=$image->getClientOriginalExtension();
            do {
                $nom=str_random(10).'.'.$extension;
            } while(file_exists($chemin.'/'.$nom));

            return ['chemin'=>$chemin,'filename'=>$nom];
        }

    }

    //
    public function addItemToDb(ProduitRequest $request) {

        if($this->isNewItem($request->input('libelle'))) {
            // NOUVEAU PRODUIT
            $stockage = new Stockage;
            $item = new Produits;
            $item->reference = $request->input('reference');
            $item->libelle = $request->input('libelle');
            $item->prix_achat = $request->input('prix_achat');
            $item->prix_unitaire = $request->input('prix_unitaire');

            $stockage->produit = $item->reference;
            $stockage->boutiques = $request->input('boutiques');
            $stockage->quantite = $request->input('quantite');
            if($request->hasFile('image')) {
              // l'image existe
              $tmp = $this->getImage($request->file('image'));
              if($request->file('image')->move($tmp['chemin'],$tmp['filename'])) {
               $item->image=$tmp['filename'];
               $item->save();
               $stockage->save();
               $this->addEntree($stockage->produit,$stockage->boutiques,$stockage->quantite);

             } else {
               return redirect('admin/add-item')->with('error',"Error , try again later..");
             }
           } else {
              // possibilite d'enregistrer un produit sans image
              $item->image = "null";
              $item->save();
              $stockage->save();
              $this->addEntree($stockage->produit,$stockage->boutiques,$stockage->quantite);
           }
           return redirect('admin/add-item')->with('success',"New Item added : `$item->libelle` in : `$stockage->boutiques`");
    }
        //  ANCIEN PRODUIT

        $itemExist = Produits::select()->where('libelle',$request->input('libelle'))->first();
        if($this->isInStock($itemExist->reference,$request->input('boutiques'))) {
            // AUGMENTER LA QUANTITE EN STOCK
            $stockExistant = Stockage::select()->where([
                ['produit',$itemExist->reference],
                ['boutiques',$request->input('boutiques')]
            ])->first();
            $stockExistant->quantite+=$request->input('quantite');
            $tmp = Stockage::where('produit',$itemExist->reference)
                            ->where('boutiques',$request->input('boutiques'))
                            ->update(['quantite' => $stockExistant->quantite]);
            $this->addEntree($stockExistant->produit,$stockExistant->boutiques,$stockExistant->quantite);
            return redirect('admin/add-item')->with('success',"Success ".$request->input('quantite')." $itemExist->libelle added to $stockExistant->boutiques");
        }
        else {
            // AJOUTER EN STOCK

            $boutiques = $request->input('boutiques');
            $stockage = new Stockage;
            $stockage->produit = $itemExist->reference;
            $stockage->boutiques=$boutiques;
            $stockage->quantite=$request->input('quantite');
            $stockage->save();
            $this->addEntree($stockage->produit,$stockage->boutiques,$stockage->quantite);
            return redirect('admin/add-item')->with('success'," $itemExist->libelle is now available in $boutiques");
        }
    }
    // ====

    public function getListItem(Request $request) {

        if($request->input('ref') && $request->input('ref') !== 'all') {
            $filter=$this->getItemByLocalisation($request->input('ref'));
            return response()->json($filter);
        }
        // traitement de la requete AJAX
        $items = Produits::select()->get();
        $quantite =[];
        $all = [];
        foreach($items as $key => $values) {
            $quantite = Stockage::select()->where('produit',$values->reference)->sum('quantite');
            $all[$key] = $this->organize($values,$quantite);
        }

        return response()->json($all);
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

    // recherche rapide des produits

    public function searchItem(Request $request) {
        $temp = $this->getListItem($request)->original;
        $wordSearch = $request->input('wordSearch');
        if($wordSearch=="") {
            return response()->json($temp);
        }
        $result = [];
        foreach ($temp as $key => $values) {
            if(str_contains(strtolower($values['libelle']),strtolower($wordSearch))) {
                // $result[$key] = $values;
                array_push($result,$values);
            }
        }

        if(count($result) > 0) {
            return response()->json($result);
        }

        return response()->json("undefined");
    }

    public function addEntree ($produit,$boutique,$quantite) {
        $entree = new Entree;
        $entree->produit = $produit;
        $entree->boutique = $boutique;
        $entree->quantite = $quantite;
        $entree->save();
    }


    // VERIFICATION DU NIVEAU DANS LE STOCK DES DIFFERENTS PRODUITS

    public function niveauStock () {

    }

}
