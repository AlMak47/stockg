@extends('layouts.app_gerant')
@section('title')
Dashboard
@endsection
@section('gerant_contents')
<div class="uk-container uk-margin-small">
	<h3 class="uk-h1 uk-visible@m">Dashboard <span class="uk-align-right uk-h4"><span uk-icon="icon:location;ratio:0.8"></span> {{$boutique}} </span>
		<span class="uk-h4 uk-align-right"><span uk-icon="icon:calendar"></span> {{$date}}</span></h3>
	<div class="uk-child-width-1-2@m uk-visible@m" uk-grid>
		<div>
			<div class="uk-card uk-card-primary">
			    <div class="uk-card-header">
			        <h3 class="uk-card-title uk-text-center">COMMANDES <span uk-icon="icon:cart;ratio:2"></span></h3>
			    </div>
			    <div class="uk-card-body">
			    	<h4 class="uk-h1 uk-text-center">{{$command}}</h4>
			    </div>
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-primary">
			    <div class="uk-card-header">
			        <h3 class="uk-card-title uk-text-center">CASH (GNF)</h3>
			    </div>
			    <div class="uk-card-body">
			    	<h4 class="uk-h1 uk-text-center">{{$cash}}</h4>
			    </div>
			</div>
		</div>
	</div>

	<div class="uk-child-width-1-2@m uk-hidden@m uk-margin-xlarge-top" uk-grid>
		<div>
			<div class="uk-card uk-card-primary">
			    <div class="uk-card-header">
			        <h3 class="uk-card-title uk-text-center">COMMANDES <span uk-icon="icon:cart;ratio:2"></span></h3>
			    </div>
			    <div class="uk-card-body">
			    	<h4 class="uk-h1 uk-text-center">{{$command}}</h4>
			    </div>
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-primary">
			    <div class="uk-card-header">
			        <h3 class="uk-card-title uk-text-center">CASH (GNF)</h3>
			    </div>
			    <div class="uk-card-body">
			    	<h4 class="uk-h1 uk-text-center">{{$cash}}</h4>
			    </div>
			</div>
		</div>
	</div>
</div>
<!-- TOUS LES PRODUITS -->
<div class="uk-container">
	<h3 class="uk-h2"><span uk-icon="icon:thumbnails;ratio:2"></span> List Items</h3>
		<hr class="uk-divider-small">
		<table class="uk-table uk-table-justify uk-table-divider">
	    <thead>
	        <tr>
	            <th>Libelle</th>
	            <th>Quantite Disponible</th>
	            <th>Prix Unitaire</th>
	            <th>Illustration</th>
	            <th>Action</th>
	        </tr>
	    </thead>
	    <tbody id="list-item"></tbody>
	</table>
</div>
@endsection
@section('gerant_script')
<script type="text/javascript">
	$(function(){
		$adminPage.getPanier("{{csrf_token()}}","{{url()->current()}}/"+"get-panier");
		// FINALISATION DE LA COMMANDE
		$adminPage.finaliseCommand("{{csrf_token()}}","command/finalise","");
		// RECUPERATION DE LA LISTE DES PRODUITS
		$adminPage.getDataFormAjax('all',"{{csrf_token()}}","{{url()->current()}}/"+"list-item",['libelle','quantite','prix_achat','prix_unitaire','photo','','details'],$("#list-item"),2,true);
		$("#command-en-cours").on('click',function() {
			$adminPage.detailsPanierOnGerant("{{csrf_token()}}","{{url()->current()}}");
		});
		// setTimeout($adminPage.getPanier("{{csrf_token()}}","{{url()->current()}}/"+"get-panier"), 1000);
	})
</script>
@endsection
