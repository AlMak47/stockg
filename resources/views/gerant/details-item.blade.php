@extends('layouts.app_gerant')
@section('title')
Details Item
@endsection

@section('gerant_contents')
<!-- TOUS LES PRODUITS -->

<div class="uk-container">
	<h3 class="uk-h3">Details Item</h3>

		<hr class="uk-divider-small">

		<div class="uk-grid-match uk-child-width-1-2@m" uk-grid>
			<div><img src="{{asset('uploads/'.$details[0]->image)}}" class="uk-width-medium uk-height-medium uk-border-rounded uk-box-shadow-small" uk-img></div>
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
