@extends('layouts.app_gerant')

@section('title')
New Command
@endsection
@section('gerant_contents')

<div class="uk-container uk-hidden@m" style="margin-top:100px !important;">
	<h3 class="uk-h1"><span uk-icon="icon:grid;ratio:2"></span> Add Command <span class="uk-align-right uk-h4"><span uk-icon="icon:location;ratio:0.8"></span> {{$boutique}} </span></h3>
</div>
<!-- TOUS LES PRODUITS -->

<div class="uk-container">
	<h3 class="uk-h3">Add Command </h3>
		<hr class="uk-divider-small">
		<!-- <div class="uk-alert uk-alert-infos" id="zone-infos"></div> -->

		@if(!session()->exists('command_en_cours'))
		{!!Form::open(['url'=>'gerant/command/new-command','id'=>'new-command'])!!}
		{!!Form::submit('New command',['class'=>'uk-button uk-button-primary uk-border-rounded uk-box-shadow-small'])!!}
		{!!Form::close()!!}
		@endif

		<table class="uk-table uk-table-justify uk-table-striped">
	    <thead>
	            <th>Libelle</th>
	            <th>Quantite</th>
	            <th>Prix Unitaire</th>
	            <th>Photos</th>
	            <th colspan="2">Action</th>
	    </thead>
	    <tbody id="list-item"></tbody>
	</table>
</div>
<input type="hidden" id="token" value="{{csrf_token()}}">
@endsection
@section('gerant_script')
<script type="text/javascript">

	$(function() {
		// FINALISER LA COMMANDE
		$adminPage.finaliseCommand("{{csrf_token()}}","finalise","");
		$adminPage.getDataFormAjax('all',"{{csrf_token()}}",'',['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"),2);
		$adminPage.getPanier("{{csrf_token()}}","{{url()->current()}}/"+"get-panier");
		setInterval(function() {
				// DETAILS DU PANIER EN COURS
			$adminPage.getPanier("{{csrf_token()}}","{{url()->current()}}/"+"get-panier");
			// RECUPERATION DE LA LISTE DES PRODUITS
			// $adminPage.getDataFormAjax('all',"{{csrf_token()}}",'',['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"),2);
		},5000);
		setInterval(function() {

			// $adminPage.getPanier("{{csrf_token()}}","{{url()->current()}}/"+"get-panier");
			// RECUPERATION DE LA LISTE DES PRODUITS
			$adminPage.getDataFormAjax('all',"{{csrf_token()}}",'',['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"),2);
		},20000);
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
				UIkit.modal.alert(data).then(function() {
					$(location).attr('href','');
				});
			})
			.fail(function (data) {
				console.log(data);
			})
		});
		// $("#new-command").submit();
		// $adminPage.getPanier("{{csrf_token()}}");

		$("#command-en-cours").on('click',function() {
			$adminPage.detailsPanierOnGerant("{{csrf_token()}}","{{url()->current()}}/"+"get-details");
		});
	});
</script>
@endsection
