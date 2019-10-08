@extends('layouts.app_admin')
@section('title')
List Commmand
@endsection

@section('admin_contents')
<div class="uk-container uk-container-large">
	<ul uk-tab>
    <li><a href="#">List Command</a></li>
    <li><a href="#">Sales List</a></li>
</ul>
<div class="uk-grid-small uk-child-width-1-3@m" uk-grid>
	<div>
			<!-- filter by boutique -->
			<h1 class="uk-h5"><span uk-icon="icon:location;ratio:0.7"></span> Filter by Boutique</h1>
		<select name="boutique" class="uk-select uk-border-rounded" id="filter-by-boutique">
			<option value="all">All</option>
			@foreach($boutiques as $values)
			<option value="{{$values->localisation}}">{{$values->localisation}}</option>
			@endforeach
		</select>
	</div>

	<div>
		<h1 class="uk-h5"><span uk-icon="icon:calendar;ratio:0.7"></span> Filter by date</h1>
		{!!Form::open(['url'=>'admin/list-command/filter-by-date','class'=>'uk-grid-small','uk-grid','id'=>'filter-date'])!!}
		<div class="uk-width-2-4@s uk-width-2-5@m">
			{!!Form::text('date_depart',null,['class'=>'uk-input select_date uk-border-rounded','placeholder'=>'Du'])!!}
		</div>
		<div class="uk-width-2-4@s uk-width-2-5@m">
			{!!Form::text('date_fin',null,['class'=>'uk-input select_date uk-border-rounded','placeholder'=>'Au'])!!}
		</div>
		<div class="uk-width-1-5@s uk-visible@m">
		{!!Form::submit('Ok',['class'=>'uk-button uk-button-primary uk-box-shadow-small uk-border-rounded'])!!}
		</div>
		<div class="uk-width-1-1@s uk-hidden@m">
			{!!Form::submit('Ok',['class'=>'uk-button uk-button-primary uk-box-shadow-small uk-width-1-1 uk-border-rounded'])!!}
		</div>
		{!!Form::close()!!}
	</div>
	<div class="">
		<h1 class="uk-h5"><span uk-icon="icon:search;ratio:0.7"></span> Search</h1>
		{!!Form::open(['url'=>''])!!}
		{!!Form::text('search_list_vente','',['class'=>'uk-input uk-border-rounded','placeholder'=>'Search ...'])!!}
		{!!Form::close()!!}
	</div>
</div>
<div id="loading" uk-spinner></div>
<ul class="uk-switcher uk-margin">
    <li>
			<h3 class="uk-h3"> List Command </h3>
					<hr class="uk-divider-small">

					<table class="uk-table uk-table-small uk-table-hover uk-table-justify uk-table-responsive uk-table-striped">
						<thead>
							<tr>
								<th>Code</th>
								<th>Date</th>
								<th>Boutique</th>
								<th>Status</th>
								<th>Cash (GNF)</th>
								<th>-</th>
							</tr>
						</thead>
						<tbody id="list-command"></tbody>
					</table>


		</li>
    <li>
			<h3 class="uk-h3"> Sales List</h3>
					<hr class="uk-divider-small">
					<table  class="uk-table uk-table-small uk-table-justify uk-table-hover uk-table-responsive uk-table-striped">
						<thead>
							<tr>
								<th class="">Item</th>
								<th class="">Quantity</th>
								<th class="">Buying Price</th>
								<th class="">Unit Price</th>
								<th class="">Date</th>
								<th class="">IdCommande</th>
								<th class="">Shop</th>
								<th class="">Total</th>
								<th class="">Benefit</th>
								<!-- <th>Image</th> -->
								<th>-</th>
							</tr>
						</thead>
						<tbody id="l-vente"></tbody>
					</table>
		</li>
</ul>
</div>
@endsection

@section('admin_script')
<script type="text/javascript">
	$(function() {


		myVue.getSalesList("{{csrf_token()}}","{{url('admin/sales-list')}}","all")

		$('.select_date').datepicker({
			  dateFormat: "yy-mm-dd"
			});
		$adminPage.filterByDate($("#filter-by-boutique").val());
		//RECUPERATION DE LA LISTE DES COMMANDES
		$adminPage.getListCommand("{{csrf_token()}}","{{url()->current()}}",'');
		// //
		// recuperation du listing des ventes

		//
		setInterval(function() {
				// DETAILS DU PANIER EN COURS
			// $adminPage.getPanier("{{csrf_token()}}","{{url()->current()}}/"+"get-panier");
			// RECUPERATION DE LA LISTE DES PRODUITS
			// $adminPage.getDataFormAjax('all',"{{csrf_token()}}",'',['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"),2);
			$adminPage.getListCommand("{{csrf_token()}}","{{url()->current()}}",'');
		},100000);
		// ///
		$("#filter-by-boutique").on('change',function () {
			if($(this).val() == "all") {
				$adminPage.getListCommand("{{csrf_token()}}","{{url()->current()}}",'');
				$adminPage.filterByDate($(this).val());
			} else {
				// ENVOI DE LA REQUETE AJAX
				$adminPage.getListCommandFilter("{{csrf_token()}}","{{url()->current().'/'.'filter'}}",$(this).val());
				$adminPage.filterByDate($(this).val());
			}
		});
		// loading
		$(document).ajaxSuccess(function () {
			$("#loading").hide();
		});
		$(document).ajaxStart(function() {
			$("#loading").show();
		});


	});
</script>
@endsection
