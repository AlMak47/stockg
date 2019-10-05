@extends('layouts.app_gerant')
@section('title')
Command
@endsection
@section('gerant_contents')
<div class="uk-container uk-visible@m">
	<h3 class="uk-h1"><span uk-icon="icon:grid;ratio:2"></span> List Command <span class="uk-align-right uk-h4"><span uk-icon="icon:location;ratio:0.8"></span> {{$boutique}} </span>
		<span class="uk-h4 uk-align-right">{{$date}}</span></h3>
</div>
<div class="uk-container uk-hidden@m" style="margin-top:100px !important;">
	<h3 class="uk-h1"><span uk-icon="icon:grid;ratio:2"></span> List Command <span class="uk-align-right uk-h4"><span uk-icon="icon:location;ratio:0.8"></span> {{$boutique}} </span>
		<span class="uk-h4 uk-align-right">{{$date}}</span></h3>
</div>
<!-- TOUS LES PRODUITS -->

<div class="uk-container">
	<ul class="uk-breadcrumb">
	    <li><a href=""><span uk-icon="icon:home"></span></a></li>
	    <li><span>List Items</span></li>
	</ul>

		<hr class="uk-divider-small">
		<div class="uk-child-width-1-2@m" uk-grid>

			<div>
				<h1 class="uk-h5">Filter by date</h1>
				{!!Form::open(['url'=>'gerant/command/list/by-date','class'=>'uk-grid-small','uk-grid','id'=>'by-date'])!!}
				<div class="uk-width-2-5@s">
					{!!Form::text('date_depart',null,['class'=>'uk-input select_date','placeholder'=>'Du'])!!}
				</div>
				<div class="uk-width-2-5@s">
					{!!Form::text('date_fin',null,['class'=>'uk-input select_date','placeholder'=>'Au'])!!}
				</div>
				<div class="uk-width-1-5@s">
				{!!Form::submit('Ok',['class'=>'uk-button uk-button-default','id'=>'btn-submit'])!!}
				</div>
				{!!Form::close()!!}
			</div>
		</div>
		<!-- <div class="uk-alert uk-alert-infos" id="zone-infos"></div> -->
		<table class="uk-table">
			<thead>
				<tr>
					<th>Code</th>
					<th>Date</th>
					<th>Status</th>
					<th>Cash (GNF)</th>
				</tr>
			</thead>
			<tbody id="list-command"></tbody>
		</table>

</div>
<input type="hidden" id="token" value="{{csrf_token()}}">
@endsection
@section('gerant_script')
<script type="text/javascript">

	$(function() {
		$('.select_date').datepicker({
			  dateFormat: "yy-mm-dd"
			});
		// FINALISER LA COMMANDE
		$adminPage.finaliseCommand("{{csrf_token()}}","finalise","");
		$adminPage.getPanier("{{csrf_token()}}","{{url()->current()}}/"+"get-panier");
		// RECUPERATION DE LA LISTE DES PRODUITS
		// $adminPage.getDataFormAjax('all',"{{csrf_token()}}",'',['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"),2);
		//RECUPERATION DE LA LISTE DES COMMANDES
		$adminPage.getListCommand("{{csrf_token()}}","{{url()->current()}}",'',false);

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

		// filtrer la liste par date
		$("#by-date").on('submit',function (e) {
			e.preventDefault()
			// UIkit.modal("#loading").show()
			$("#btn-submit").hide(300)
			$.ajax({
				url : $(this).attr('action'),
				type : 'post',
				dataType : 'json',
				data : $(this).serialize()
			})
			.done(function(data) {
				UIkit.modal("#loading").hide()
				$adminPage.createTableDataCommand(data,['code','date','boutique','status','cash',''],$("#list-command"),true);
				$("#btn-submit").show(300)
			})
			.fail(function (data) {
				alert(data.responseJSON.message)
				$(location).attr('href',"{{url()->current()}}")
			})
		})
	});
</script>
@endsection
