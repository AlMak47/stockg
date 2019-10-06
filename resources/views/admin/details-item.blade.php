@extends('layouts.app_admin')
@section('title')
Details Item
@endsection
@section('admin_contents')

<div class="uk-container">

	<h3 class="uk-h3"><a href="{{url('admin/list-item')}}" class="uk-button"> <span uk-tooltip="List Items" class="uk-button-primary uk-border-circle" uk-icon="arrow-left"></span> </a> Details Item</h3>
		<hr class="uk-divider-small">

		<div class="uk-grid-small uk-child-width-1-2@m" uk-grid>
			<div><img src="{{asset('uploads/'.$details[0]->image)}}" class="uk-width-medium uk-height-medium uk-border-rounded uk-box-shadow-small" uk-img></div>
			<div>
				<ul class="uk-list uk-list-divider">
					<li class="uk-text-lead">Reference : {{$details[0]->reference}}</li>
					<li  class="uk-text-lead">Item Name : {{$details[0]->libelle}}</li>
					<li  class="uk-text-lead">Selling price (GNF) : <span>{{number_format($details[0]->prix_unitaire)}}</span></li>
					<li  class="uk-text-lead">Buying price (GNF) : <span>{{number_format($details[0]->prix_achat)}}</span></li>
					<li  class="uk-text-lead">Pieces : {{$details[1]}}</li>
				</ul>
			</div>
		</div>

<input type="hidden" id="token" value="{{csrf_token()}}">
@endsection
@section('admin_script')
<script type="text/javascript">

	$(function() {

	});
</script>
@endsection
