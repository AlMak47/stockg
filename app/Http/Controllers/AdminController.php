<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\BoutiqueRequest;
use App\Http\Requests\ProduitRequest;
use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Support\Facades\Hash;
use App\Traits\Similarity;
use App\Boutique;
use App\User;
use App\Produits;
use App\Stockage;
use App\Command;
use Carbon\Carbon;
use App\Sortis;
use App\Entree;
// use App\Produits;
class AdminController extends Controller
{
    //
    use Similarity;
    protected $_users,$daily_cash,$date,$dayCommand;
    public function __construct() {
        // $this->middleware('guest');
        $this->_users = User::select()->where('statut','gerant')->get();
        $this->daily_cash = $this->cashOfDay();
        $this->date =$this->dateOfDay();
        $this->dayCommand = $this->commandOfDay();
    }

    public function dashboard() {
    	return view('admin.dashboard')->withUlist($this->_users)
                                ->withDcash($this->daily_cash)
                                ->withDate($this->date)
                                ->withDaycommand($this->dayCommand);
    }
    // FORMULAIRE D'AJOUT DE GERANTS
    public function addGerant() {      
        // dd($this->date);  
    	return view('admin.add-gerant')->withDate($this->date);
    }
    // ENVOI DES INFORMATIONS DANS LA BASE DE DONNEES
    public function addGerantToDb(UserRequest $request) {
        $users = new User;
        $users->email = $request->input('email');
        $users->username = $request->input('username');
        $users->phone=$request->input('phone');
        $users->statut=$request->input('statut');
        $users->password=bcrypt($request->input('password'));
        $request->session()->put('user',$users);
       
            return view('admin/add-boutique')->with('user',$users)->withDate($this->date);
    }
    // FORMULAIRE D'AJOUT DE BOUTIQUE
    public function addBoutique() {
        // dd($this->date);
        return view('admin.add-boutique')->withDate($this->date);
    }
    // ENVOI DES INFORMATIONS DANS LA BASE DE DONNEES
    public function addBoutiqueToDb(BoutiqueRequest $request) {
        $boutique = new Boutique;
        $boutique->localisation = $request->input('localisation');
        $boutique->users = $request->input('username');
        if($boutique->users === $request->session()->get('user')->username) {    
            $request->session()->get('user')->save();
            $boutique->save();
            return redirect('admin/list-gerant')->with('msg','Ajouter avec success');
        }
        
    }
    // AFFICHAGE DE LA LISTE DES GERANTS
    public function listGerant() {
        $boutiques =[];
        foreach($this->_users as $key => $value) {
            $boutiques[$key] = Boutique::select()->where('users',$value->username)->get();
        }

        return view('admin.list-gerant')->withUlist($this->_users)
                                        ->withBoutique($boutiques)
                                        ->withDate($this->date);
    }

    public function addItem() {
        $boutiques = Boutique::select()->get();
        return view('admin.add-items')->withBouti($boutiques)->withDate($this->date);
    }


    public function listItem() {
        $boutiques = Boutique::select()->get();
        return view('admin.list-item')->withBoutiques($boutiques)->withDate($this->date);
    }

    public function listCommand() {
        $boutiques = Boutique::select()->get();
        // $commande = Command::select()->orderBy('created_at','desc')->simplePaginate(5);
        return view('admin.list-command')->withBoutiques($boutiques)->withDate($this->date);
    }

    public function getListCommand() {
        // recuperation de la liste des commande
        $commande = Command::select()->orderBy('created_at','desc')->get(5);
        $all = $this->organizeCommand($commande);
        return response()->json($all);
    }
    // liste des commandes en fonction de la boutique

    public function getCommandByFilter(Request $request) {
        $commandFiltrer = "";
        if($request->input('ref') && $request->input('ref') !==""){
            $commandFiltrer = Command::select()->where('boutique',$request->input('ref'))->orderBy('created_at','desc')->get();
            $all = $this->organizeCommand($commandFiltrer);
        }
        return response()->json($all);
    }

    public function detailsItem($id) {
         $item = Produits::select()->where('reference',$id)->first();
        // recuperation de la quantite en stock 
        $quantite =0;
        $tmp = Stockage::select()->where('produit',$id)->sum('quantite');
        
        return view('admin.details-item')->withDetails([$item,$tmp]);
    }
    
    public function Profile() {
        return view('admin.profile')->withDate($this->date);
    }    

    public function changePassword(PasswordChangeRequest $request) {
        if(Hash::check($request->input('old_password'),Auth::user()->password)) {
            $newPassword = bcrypt($request->input('new_password'));
            User::select()->where('username',Auth::user()->username)->update(['password'=>$newPassword]);
            return redirect('admin/profile')->with('success','Changement effectue avec success');
        }
        return redirect('admin/profile')->with('error','Le Mot de passe ne correspond pas');
    }
    
    public function detailsCommand($code) {

        $details = Command::select()->where('code',$code)->first();
        $items = $this->getItemByCommand($code);
        $all = $this->getDetailsCommand($items);
        $totalCom=number_format($this->totalCashCommand($code));
        $interet = number_format($this->getInteret(false,null,$code));
        // dd($details);
        return view('admin.details-command')->withDetails($all)
                                            ->withCode($code)
                                            ->withStatus($details->status)
                                            ->withTotal($totalCom)
                                            ->withInteret($interet)
                                            ->withBoutique($details->boutique);
    }

    // filtrer par date 

    public function filterByDate(Request $request) {

        if($request->input('ref') == "all") {
           $filterDate = Command::select()->whereBetween('created_at',array($request->input('date_depart'),$request->input('date_fin')))->get();
        } else {
            $filterDate = Command::select()->where('boutique',$request->input('ref'))->whereBetween('created_at',array($request->input('date_depart'),$request->input('date_fin')))->get();
        }
        $all = $this->organizeCommand($filterDate);
        return response()->json($all);
    }
    // cash global du jour
    public function cashOfDay() {
        $date = $this->dateOfDay();
        $total=0;
        $commandes = Command::select()->where('status','confirme')->whereDate('created_at',Carbon::now()->toDateString())->get();
        foreach($commandes as $key => $values) {
            $total+=$this->totalCashCommand($values->code);
        }
        return number_format($total);
    }

    // BILAN

    public function bilan() {
        $stockValue = $this->totalInStock();
        $dayValue = $this->totalByDay();
        $entree = $this->getEntree();
        $boutiques = Boutique::select()->get();
        $interet = $this->getInteret();

        return view('admin.bilan')->withDate($this->date)
                                ->withTotalinstock($stockValue)
                                ->withDayvalue($dayValue)
                                ->withEntree($entree)
                                ->withBoutiques($boutiques)
                                ->withInteret($interet);
    }

    // nombre de commande du jour
    public function commandOfDay() {
        $date = $this->dateOfDay();
        $nb = Command::select()->whereDate('created_at',Carbon::now()->toDateString())->get()->count();
        if($nb >= 0) {
            return $nb;
        }
        return false;
    }

    // calcul du total en stock 

    public function totalInStock($boutiqueOption=false,$boutique=null) {
        $quantite =0;
        $totalStock = 0;

        if($boutiqueOption && $boutique!=null) {
            // filtre pour les boutiques
            $items = Stockage::select()->where('boutiques',$boutique)->get();
            foreach($items as $key => $values) {
                $prix_achat = Produits::select()->where('reference',$values->produit)->first()->prix_achat;
                $totalStock += $prix_achat * $values->quantite;
            }

        } else {
            $items = Produits::select()->get();    
            foreach($items as $key => $values) {
                $quantite = Stockage::select()->where('produit',$values->reference)->sum('quantite');
                $totalStock += $values->prix_achat * $quantite;
            }
        }

        
        return $totalStock;
    }
    // calcul du total vendu par jour 
    public function totalByDay($boutiqueOption=false,$boutique=null) {
        $cash =0;

        if($boutiqueOption && $boutique!=null) {
            $items = Command::select()->where('boutique',$boutique)->where('status','confirme')->whereDate('created_at',Carbon::now()->toDateString())->get();
        } else {
            $items = Command::select()->where('status','confirme')->whereDate('created_at',Carbon::now()->toDateString())->get();
        }
        
        foreach($items as $key => $values) {
            $cash += $this->totalCashCommand($values->code);
        }
        return $cash;
    }

    // calcul du benefice
    public function getInteret($boutiqueOption=false,$boutique=null,$unique=null) {
        $interet = 0;

        if($boutiqueOption && $boutique!=null) {
            $items = Command::select()->where('boutique',$boutique)->where('status','confirme')->whereDate('created_at',Carbon::now()->toDateString())->get();
        } else {
            $items = Command::select()->where('status','confirme')->whereDate('created_at',Carbon::now()->toDateString())->get();
        }

        if(!is_null($unique)) {
            $items = Command::select()->where('status','confirme')->where('code',$unique)->get();
            // return $interet;
        }
        
        foreach($items as $key => $values) {
            $interet += $this->interetCommand($values->code);
        }

        return $interet;
    }

    // calcul des entrees 
    public function getEntree($boutiqueOption=false,$boutique=null) {

        $all = Entree::select()->whereDate('created_at',Carbon::now()->toDateString())->get();
        if($boutiqueOption && $boutique!=null) {
            $all = Entree::select()->where('boutique',$boutique)->whereDate('created_at',Carbon::now()->toDateString())->get();
        }

        $total = 0;

        foreach($all as $key => $values) {
            $item = Produits::select()->where('reference',$values->produit)->first();
            $vente = $item->prix_achat * $values->quantite;
            $total+=$vente;
        }

        return $total;
    }
    // FILTRER LE BILAN PAR BOUTIQUE

    public function bilanByBoutique(Request $request) {
        if($request->input('ref') == "all") {
            // bilan global
            $inStock = $this->totalInStock();
            $vendu = $this->totalByDay();
            $interet = $this->getInteret();
            $entree = $this->getEntree();
            
        } else {
            // bilan par boutique
            $inStock = $this->totalInStock(true,$request->input('ref'));
            $vendu = $this->totalByDay(true,$request->input('ref'));
            $interet = $this->getInteret(true,$request->input('ref'));
            $entree = $this->getEntree(true,$request->input('ref'));
        }
        return response()->json(['inStock' => number_format($inStock),'vendu' => number_format($vendu),'interet' => number_format($interet),'entree'=>number_format($entree)]);
    }

    public function listEntree() {
        $boutiques = Boutique::select()->get();
        return view('admin.list-entree')->withBoutiques($boutiques)->withDate($this->date);
    }

    public function getListEntree(Request $request) {

        $list = Entree::select()->distinct()->orderBy('created_at','desc')->get();
        if($request->input('ref') && $request->input('ref') !== 'all') {
            $list = Entree::select()->select()->where('boutique',$request->input('ref'))->distinct()->orderBy('created_at','desc')->get();
            // return response()->json($request);
        }
        $all = [];
        if($list->count() > 0) {
            foreach($list as $key => $values) {
                $temp = $this->getItemInfo($values->produit);
                $all[$key] = $this->organize($temp,$values->quantite);
                $date = new Carbon($values->created_at);
                // array_push($all[$key],['date' => $date->toFormattedDateString()]);
                $all[$key]['date'] = $date->toFormattedDateString();
            }
        }
        // var_dump($all);
        return response()->json($all);
    }

    // public function makeEntree ($entree) {

    // }
    public function editItem($id) {
        $boutiques = Boutique::select()->get();
        $item = Produits::select()->where('reference',$id)->first();
        // $quantite = Stockage::select()->where('')
        return view('admin.edit-items')->withBouti($boutiques)->withDate($this->date)->withItemedit($item);
    }    

    public function makeEditItem($id,Request $request) {

        if($request->file('image')) {
            // l'image existe 
        }
        else {
            // l'image n'existe pas
            // verifier si le nom existe deja
            if($this->isExistItem($request->input('libelle'))) {
                return redirect("admin/edit-item/".$id)->with('_errors','`'.$request->input('libelle').'` existe deja');
            }
            Produits::select()->where('reference',$id)->update([
                'libelle'=>$request->input('libelle'),
                'prix_achat' => $request->input('prix_achat'),
                'prix_unitaire' => $request->input('prix_unitaire')
            ]);
            return redirect("admin/edit-item/".$id)->with('success',"Update Complete");
        }
    }

    public function simplify(Request $request) {
        if($this->isExistItem($request->input('ref'))) {
            return response()->json('done');    
        }
        return response()->json('fail');
    }
}
