<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\PasswordChangeRequest;
use App\Traits\Similarity;
use App\Boutique;
use App\Stockage;
use App\User;
use App\Command;
use App\Sortis;
use App\Produits;
use Carbon\Carbon;

class GerantController extends Controller
{
    //
    use Similarity;

    protected $_users;

    public function __construct() {
        // $this->CommandInSession();
        // $date
    }

    public function dashboard() {
        $this->CommandInSession();
    	$tmp=$this->getLocalisation();
      $item = $this->ItemQuantity();
    	return view('gerant.dashboard')->withBoutique($tmp->localisation)
                        ->withDate($this->dateOfDay())
                        ->withCommand($this->commandOfDay($tmp->localisation))
                        ->withCash($this->cashOfDay($tmp->localisation))
                        ->withItem($item);
    }
    // nombre de produit en stock
    public function ItemQuantity () {
      $temp = Stockage::where('boutiques',$this->getLocalisation()->localisation)->get();
      return $temp->count();
    }
    // ajouter une commande
    public function addCommande() {
        // session()->forget('command_en_cours');
        $this->CommandInSession();
    	return view('gerant.add-commande')->withBoutique($this->getLocalisation()->localisation)
        ->withDate($this->dateOfDay());
    }

    public function getListItem() {
        // $this->CommandInSession();
        $item = $this->getItemByLocalisation($this->getLocalisation()->localisation,false);
        return response()->json($item);
    }

    public function getLocalisation () {
        // $this->CommandInSession();
        return Boutique::select()->where('users',Auth::user()->username)->first();
    }

    public function newCommand() {
        // $this->CommandInSession();
        // VERIFIONS SI LES PRODUITS SONT EN STOCK
        $stock = Stockage::select()->where('boutiques',$this->getLocalisation()->localisation)->first();
        $msg="Vous n'avez aucun produit en stock";
        if($stock) {
            // IL YA AU MOIN UN PRODUIT
            $command = new Command;
            $command->boutique=$this->getLocalisation()->localisation;
            $command->status="attente";
            $command->code='CM'.time();
            session()->put('command_en_cours',$command->code);
            $command->save();
            $msg ="Commande creée , Veuillez ajouter les produits";
        }

       return response()->json($msg);
    }

    public function addItemToCommand(Request $request) {

        // AJOUTER DES PRODUITS A LA COMMANDE EN COURS

        if(!session()->get('command_en_cours')) {
            // AUCUN COMMANDE N'EXITES

            return response()->json("Aucune commande n'est defini");
        }

        $temp = Sortis::select()->where('code_commande',session()->get('command_en_cours'))
                                ->where('produit',$request->input('ref'))->first();
        $msg = "";
        // recuperation du stock
        $boutique = $this->getLocalisation()->localisation;
        $stock = Stockage::select()->where('produit',$request->input('ref'))
                                    ->where('boutiques',$boutique)->first();
        // VERIFIER SI LA QUANTITE COMMANDE EST INFERIEUR A LA QUANTITE DISPONIBLE
        if(!$this->isValidQuantite($request->input('quantite'),$stock->quantite)) {
            // LA QUANTITE N'EST PAS VALIDE
            $msg ="La Quantite demandée n'est pas disponible";
            return response()->json($msg);
        }

        $qt_restant=0;
        if($temp) {
            // le produit existe deja dans la commande on doit modifier la quantite
            $qt_restant = $stock->quantite - $request->input('quantite');
            $temp->quantite_commande = $temp->quantite_commande + $request->input('quantite');
            Sortis::select()->where('code_commande',session()->get('command_en_cours'))
                                ->where('produit',$request->input('ref'))->update(['quantite_commande'=>$temp->quantite_commande]);
            $msg="Quantite augmentee avec success";
            // return response()->json($msg);

        } else {
            // il n'existe pas
        $sortis = new Sortis;
        $sortis->code_commande = session()->get('command_en_cours');
        $sortis->produit = $request->input('ref');
        $sortis->quantite_commande = $request->input('quantite');
        $qt_restant = $stock->quantite - $sortis->quantite_commande;

        $sortis->save();

        $msg = "ajouter avec success";
        }
        Stockage::select()->where('produit',$request->input('ref'))
                                    ->where('boutiques',$boutique)
                                    ->update(['quantite'=>$qt_restant]);

        return response()->json($msg);

    }

    public function getPanierContent() {
        // $this->CommandInSession();
        // RECUPERER LES DETAILS
        $panierContent = "";
        $nb=0;
        $boutique = $this->getLocalisation()->localisation;
        if(session()->exists('command_en_cours')) {
            // $panierContent = Command::select()->where('code',session()->get('command_en_cours'))->get();
            $panierContent = Sortis::select()->where('code_commande',session()->get('command_en_cours'))->get();
            $nb=$panierContent->count();
        }
        return response()->json(['nb'=>$nb,'command'=>$panierContent]);
    }

    public function getPanierDetails() {
        // $this->CommandInSession();
        // recuperer les informations du panier
        if(!session()->exists('command_en_cours')) {
            return response()->json("indefinie");
        }
           $command = session()->get('command_en_cours');

        $all = [];
            $sorti = Sortis::select()->where('code_commande',$command)->get();
            $cash = 0;
            foreach($sorti as $key => $values) {
            $tmp = Produits::select()->where('reference',$values->produit)->first();
            $total = $tmp->prix_unitaire * $values->quantite_commande;
            $all [$key]= [
                'reference'=>$values->produit,
                'libelle'=>$tmp->libelle,
                'prix_unitaire'=>number_format($tmp->prix_unitaire),
                'quantite'=>$values->quantite_commande,
                'total'=> number_format($total),
                'image'=>$tmp->image
            ];
            $cash+=$total;
            }
            return response()->json(['item_details'=>$all,'total_cash'=>number_format($cash)]);

    }

    // Verifier si la command est session et la mettre si elle n'y est pas
    public function CommandInSession() {
        if(session()->get('command_en_cours')) {
            //ne rien faire
        }
        else {
            // on recupere la commande en attente puis on la place en session
            $boutique = $this->getLocalisation()->localisation;
            $tmp = Command::select()->where('status','attente')
                                    ->where('boutique',$boutique)->first();
            if($tmp) {
                $command=Command::select()->where('status','attente')->first()->code;
                session()->put('command_en_cours',$command);
            }
        }
    }

    public function existCommand() {
        return Command::select()->first();
    }

    // VOIR SI LA QUANTITE DEMANDE EST INFERIEUR A LA QUANTITE EN STOCK
    public function isValidQuantite($qteDemande,$qteEnStock) {
        return ($qteEnStock >= $qteDemande);
    }

    public function listCommand() {
        $this->CommandInSession();
        return view('gerant.list-commande')->withBoutique($this->getLocalisation()->localisation)
                                            ->withDate($this->dateOfDay());
    }

    public function confirmCommand(Request $request) {
        // finalisation de la commande en cours !!!
        $msg = "";
        if(!$request->input('action')){
            $msg = "Erreur";

        }
        $commandEnCours = session()->get('command_en_cours');
        if($request->input('action') == "abort") {
            $msg = "Commande Annulée";
            // processus d'annullatioon de la commande
            $sorti = Sortis::select()->where('code_commande',$commandEnCours)->get();
            // reinitialisation des quantite
            if($sorti->count() > 0) {
                foreach($sorti as $key => $values) {
                    $this->resetQuantiteToStock($values->produit,$values->quantite_commande);
                }
            // suppression de sorti
            Sortis::select()->where('code_commande',$commandEnCours)->delete();
            }
            // suppression de la commande
            Command::select()->where('code',$commandEnCours)->delete();

            // return response()->json($sorti);
        } else {
            // processus de confirmation de la commande
            // verifier si la commande est valides
            if($this->isValidCommand($commandEnCours)) {
                // changement du status
                Command::select()->where('code',$commandEnCours)->update(['status'=>'confirme']);
                $msg = "Commande Confirmée";
            } else {
                $msg = "La Commande est Vide Veuillez ajouter au moins un produit";
            }
        }
        // suppression de la session
        session()->forget('command_en_cours');
        return response()->json($msg);
    }

    public function resetQuantiteToStock($produit,$qtr) {
        // reinitialisation de la quantite en stock apres annulation de la commande en cours
        $boutique = $this->getLocalisation()->localisation;
        $produitInStock = Stockage::select()->where('produit',$produit)
                                            ->where('boutiques',$boutique)->first();
        $produitInStock->quantite = $produitInStock->quantite + $qtr;

        Stockage::select()->where('produit',$produit)
                            ->where('boutiques',$boutique)->update(['quantite'=>$produitInStock->quantite]);

    }

    // recuperation de la liste des commandes
    public function getListCommand(Request $request) {
        $boutique=$this->getLocalisation()->localisation;
        $commandes = Command::select()->where('boutique',$boutique)->orderBy('created_at','desc')->get();
        // recuperation des produits de la command
        $all=$this->organizeCommand($commandes,false);
        return response()->json($all);
        // return response()->json($request);
    }
    // liste des commandes par date
    public function getListCommandByDate(Request $request) {
      $boutique = $this->getLocalisation()->localisation;
      $command = Command::where('boutique',$boutique)->whereBetween('created_at',[$request->input('date_depart'),$request->input('date_fin')])->orderBy('created_at','desc')->get();
      $all = $this->organizeCommand($command,false);
      return response()->json($all);
    }
    // nombre de commande du jour
    public function commandOfDay($boutique) {
        $date = $this->dateOfDay();
        $nb = Command::select()->where('boutique',$boutique)->where('status','confirme')->whereDate('created_at',Carbon::now()->toDateString())->get()->count();
        if($nb >= 0) {
            return $nb;
        }
        return false;
    }
    // cash du jour
    public function cashOfDay($boutique) {
        $date = $this->dateOfDay();
        $total=0;
        $commandes = Command::select()->where('boutique',$boutique)->where('status','confirme')->whereDate('created_at',Carbon::now()->toDateString())->get();
        foreach($commandes as $key => $values) {
            $total+=$this->totalCashCommand($values->code);
        }
        return number_format($total);
    }

    public function getProfile() {
        return view('gerant.profile')->withBoutique($this->getLocalisation()->localisation)
                                            ->withDate($this->dateOfDay());
    }

    public function changePassword(PasswordChangeRequest $request) {
        $users = Auth::user();
        if(Hash::check($request->input('old_password'),$users->password)) {
            $newPassword = bcrypt($request->input('new_password'));
            // dd($newPassword);
            User::select()->where('username',$users->username)->update(['password'=>$newPassword]);

            return redirect('gerant/profile')->with('success','Changement effectue avec success');
        }
        return redirect('gerant/profile')->with('error','Le mot de passe ne correspond pas');
    }

    // Details Item

    public function detailsItem($id) {
        $item = Produits::select()->where('reference',$id)->first();
        // recuperation de la quantite en stock
        $quantite =0;
        $tmp = Stockage::select()->where('produit',$id)->where('boutiques',$this->getLocalisation()->localisation)->first();
        $quantite=$tmp->quantite;
        // dd($item);
        // dd($id);
        return view('gerant.details-item')->withBoutique($this->getLocalisation()->localisation)
                                            ->withDate($this->dateOfDay())
                                            ->withDetails([$item,$quantite]);
    }

    public function detailsCommande($code) {
        $details = Command::select()->where('code',$code)->first();
        $items = $this->getItemByCommand($code);
        $all = $this->getDetailsCommand($items);
        $totalCom=number_format($this->totalCashCommand($code));
        // dd($code);
        return view('gerant.details-commande')->withBoutique($this->getLocalisation()->localisation)
                                            ->withDate($this->dateOfDay())
                                            ->withDetails($all)
                                            ->withCode($code)
                                            ->withStatus($details->status)
                                            ->withTotal($totalCom);
    }

}
