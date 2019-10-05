@extends('layouts.app_admin')
@section('title')
List Commmand
@endsection

@section('admin_contents')
<div class="uk-container">
<h3 class="uk-h3"> List Command </h3>
		<hr class="uk-divider-small">
		<div class="uk-child-width-1-2@m" uk-grid>
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
				<div class="uk-width-2-5@s">
					{!!Form::text('date_depart',null,['class'=>'uk-input select_date uk-border-rounded','placeholder'=>'Du'])!!}
				</div>
				<div class="uk-width-2-5@s">
					{!!Form::text('date_fin',null,['class'=>'uk-input select_date uk-border-rounded','placeholder'=>'Au'])!!}
				</div>
				<div class="uk-width-1-5@s">
				{!!Form::submit('Ok',['class'=>'uk-button uk-button-primary uk-box-shadow-small uk-border-rounded'])!!}
				</div>

				{!!Form::close()!!}
			</div>
		</div>
		<div id="loading" uk-spinner></div>
		<table class="uk-table uk-table-justify uk-table-striped">
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

</div>
@endsection

@section('admin_script')
<script type="text/javascript">
	$(function() {
		$('.select_date').datepicker({
			  dateFormat: "yy-mm-dd"
			});
		$adminPage.filterByDate($("#filter-by-boutique").val());
		//RECUPERATION DE LA LISTE DES COMMANDES
		$adminPage.getListCommand("{{csrf_token()}}","{{url()->current()}}",'');
		// //
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
