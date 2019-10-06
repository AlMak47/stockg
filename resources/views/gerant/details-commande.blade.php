@extends('layouts.app_gerant')
@section("title")
Details Command
@endsection
@section('gerant_contents')

<div class="uk-container">
	<h3 class="uk-h3"><a href="{{url('gerant/command/list')}}" class="uk-button"> <span uk-tooltip="List Command" class="uk-button-primary uk-border-circle" uk-icon="arrow-left"></span> </a>Details Command</h3>
		<hr class="uk-divider-small">

		<div class="uk-h4"><span>Command : <span class="uk-label">{{$code}}</span> </span> | <span>Status : <span class="{{ $status =='confirme' ? 'uk-label uk-label-success' : 'uk-label uk-label-danger'}}"> {{$status}}</span></span> | <span>Montant Total (GNF) : <span class="uk-text-lead">{{$total}}</span></span></div>

		<table class="uk-table uk-table-striped">
			<thead>
				<tr>
					<th>Reference</th>
					<th>Designation</th>
					<th>Prix Unitaire</th>
					<th>Quantite</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				@if($details)
				@foreach($details as $values)
				<tr>
					<td>{{$values['reference']}}</td>
					<td>{{$values['designation']}}</td>
					<td>{{$values['prix_unitaire']}}</td>
					<td>{{$values['quantite_command']}}</td>
					<td>{{$values['total']}}</td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
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
		$adminPage.getListCommand("{{csrf_token()}}","{{url()->current()}}",'');

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
