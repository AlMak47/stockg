@extends('layouts.app_admin')
@section('title')
Details Command
@endsection
@section('admin_contents')
<div class="uk-container">
	<h3 class="uk-h3"><a href="{{url('admin/list-command')}}" class="uk-button"> <span uk-tooltip="List Command" class="uk-button-primary uk-border-circle" uk-icon="arrow-left"></span> </a> Details Command</h3>
	<hr class="uk-divider-small">
		<div class="uk-h4">
			<span uk-icon="icon:location;ratio:1"></span> <span>{{$boutique}}</span> |
			<span>Id : <span class="uk-label">{{$code}}</span> </span> |
			<span>State : <span class="{{ $status =='confirme' ? 'uk-label uk-label-success' : 'uk-label uk-label-danger'}}"> {{$status}}</span> </span> |
			<span>Cash (GNF) : <span class="uk-text-lead">{{$total}}</span> </span> |
			<span>Benefit (GNF) : <span class="uk-text-lead">{{$interet}}</span> </span>
		</div>
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


<input type="hidden" id="token" value="{{csrf_token()}}">
@endsection
@section('admin_script')
<script type="text/javascript">

	$(function() {

	});
</script>
@endsection
