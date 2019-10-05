@extends('layouts.app_admin')

@section('admin_contents')

<div class="uk-container">
	<h3 class="uk-h1">Details Item</h3>
</div>
<!-- TOUS LES PRODUITS -->

<div class="uk-container">
	<ul class="uk-breadcrumb">
	    <li><a href=""><span uk-icon="icon:home"></span></a></li>
	    <li><a href="{{url('admin/list-item')}}"><span uk-icon="icon:arrow-left;ratio:1"></span>List item</a></li>
	    <li><span>Details Item</span></li>
	</ul>

		<hr class="uk-divider-small">

		<div class="uk-grid-match uk-child-width-1-2@m" uk-grid>
			<div><img src="{{asset('uploads/'.$details[0]->image)}}" class="uk-width-medium uk-height-medium uk-animation-kenburns" uk-img></div>
			<div>
				<ul class="uk-list uk-list-divider">
					<li class="uk-text-lead">Reference : {{$details[0]->reference}}</li>
					<li  class="uk-text-lead">Name : {{$details[0]->libelle}}</li>
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
