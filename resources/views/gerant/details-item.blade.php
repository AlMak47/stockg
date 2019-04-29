@extends('layouts.app_gerant')

@section('gerant_contents')

<div class="uk-container">
	<h3 class="uk-h1">Details Item <span class="uk-align-right uk-h4"><span uk-icon="icon:location;ratio:0.8"></span> {{$boutique}} </span>
		<span class="uk-h4 uk-align-right">{{$date}}</span></h3>
</div>
<!-- TOUS LES PRODUITS -->

<div class="uk-container">
	<ul class="uk-breadcrumb">
	    <li><a href=""><span uk-icon="icon:home"></span></a></li>
	    <li><span>Details Item</span></li>
	</ul>

		<hr class="uk-divider-small">

		<div class="uk-grid-match uk-child-width-1-2@m" uk-grid>
			<div><img src="{{asset('uploads/'.$details[0]->image)}}" class="uk-width-small uk-animation-kenburns" uk-img></div>	
			<div>
				<ul class="uk-list uk-list-divider">
					<li>Reference : {{$details[0]->reference}}</li>
					<li>Name : {{$details[0]->libelle}}</li>
					<li>Price (GNF) : {{number_format($details[0]->prix_unitaire)}}</li>
					<li>Pieces : {{$details[1]}}</li>
				</ul>
			</div>	
		</div>
		
<input type="hidden" id="token" value="{{csrf_token()}}">
@endsection
@section('gerant_script')
<script type="text/javascript">

	$(function() {
		// FINALISER LA COMMANDE
		$adminPage.finaliseCommand("{{csrf_token()}}","finalise","");
		$adminPage.getPanier("{{csrf_token()}}","{{url()->current()}}/"+"get-panier");
		// RECUPERATION DE LA LISTE DES PRODUITS
		// $adminPage.getDataFormAjax('all',"{{csrf_token()}}",'',['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"),2);
		//RECUPERATION DE LA LISTE DES COMMANDES
		// $adminPage.getListCommand("{{csrf_token()}}","{{url()->current()}}",''); 

		// console.log($("td:empty"));
		$("#new-command").on('submit',function(e) {
			e.preventDefault();
			$.ajax({
				url :$(this).attr('action'),
				type :$(this).attr('method'),
				data:$(this).serialize(),
				dataType :'json'
			})
			.done(function (data) {
				// alert('Command creee,Veuillez ajoutez les produits');
				UIkit.modal.alert(data);
			})
			.fail(function (data) {
				console.log(data);
			})
		});

		$("#command-en-cours").on('click',function() {
			$adminPage.detailsPanierOnGerant("{{csrf_token()}}","{{url()->current()}}/"+"get-details");			
		});
	});
</script>
@endsection