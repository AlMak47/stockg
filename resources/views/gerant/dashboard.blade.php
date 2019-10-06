@extends('layouts.app_gerant')
@section('title')
Dashboard
@endsection
@section('gerant_contents')
<div class="uk-container uk-margin-small">
	<h3 class="uk-h3 uk-visible@m">Dashboard</h3>
	<div class="uk-grid-small uk-child-width-1-4@m uk-visible@m" uk-grid>
		<div>
			<div class="uk-card uk-card-default uk-card-primary uk-border-rounded uk-box-shadow-small">
			    <div class="uk-card-header">
			        <h4 class="uk-card-title uk-text-center">COMMANDES <span uk-icon="icon:cart"></span></h4>
			    </div>
			    <div class="uk-card-body">
			    	<h4 class="uk-h1 uk-text-center">{{$command}}</h4>
			    </div>
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-default uk-card-primary uk-border-rounded uk-box-shadow-small">
			    <div class="uk-card-header">
			        <h4 class="uk-card-title uk-text-center">CASH (GNF) <span uk-icon="icon:credit-card"></span></h4>
			    </div>
			    <div class="uk-card-body">
			    	<h4 class="uk-h1 uk-text-center">{{$cash}}</h4>
			    </div>
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-default uk-card-primary uk-border-rounded uk-box-shadow-small">
			    <div class="uk-card-header">
			        <h4 class="uk-card-title uk-text-center">ITEMS <span uk-icon="icon:list"></span></h4>
			    </div>
			    <div class="uk-card-body">
			    	<h4 class="uk-h1 uk-text-center">{{$item}}</h4>
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
	<h3 class="uk-h3">List Items</h3>
		<hr class="uk-divider-small">
		<div class="uk-grid-small uk-child-width-1-2@m" uk-sticky uk-grid>
			<div class="">
				<!-- search -->
				{!!Form::open(['url'=>''])!!}
				<label for=""><span uk-icon="icon : search"></span> Search</label>
				{!!Form::text('search_item','',['class'=>'uk-input uk-border-rounded uk-margin-small','id'=>'search'])!!}
				{!!Form::close()!!}
			</div>
		</div>
		<table class="uk-table uk-table-justify uk-table-striped">
	    <thead>
	        <tr>
	            <th>Item</th>
	            <th>Quantity</th>
	            <th>Unit Price (GNF)</th>
	            <th>Image</th>
	            <th>-</th>
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
		$("#search").on('keyup',function() {
			$adminPage.findItem("{{csrf_token()}}","{{url()->current()}}/search-item","{{$boutique}}",$(this).val());
		});
	})
</script>
@endsection
