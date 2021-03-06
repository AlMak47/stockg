@extends('layouts.app_admin')
@section('title')
{{__("Details Item")}}
@endsection
@section('admin_contents')

<div class="uk-container">

	<h3 class="uk-h3"><a href="{{url('admin/list-item')}}" class="uk-button"> <span uk-tooltip="{{__('List Item')}}" class="uk-button-primary uk-border-circle" uk-icon="arrow-left"></span> </a> {{__("Details Item")}}</h3>
		<hr class="uk-divider-small">

		<div class="uk-grid-small uk-child-width-1-2@m" uk-grid>
			@if($details[0]->image !== "null")
			<div><img src="{{asset('uploads/'.$details[0]->image)}}" class="uk-width-medium uk-height-medium uk-border-rounded uk-box-shadow-small" uk-img></div>
			@else
			
			@endif
			<div>
				<ul class="uk-list uk-list-divider">
					<li class="uk-text-lead">{{__("Id")}} : {{$details[0]->reference}}</li>
					<li  class="uk-text-lead">{{__("Item Name")}} : {{$details[0]->libelle}}</li>
					<li  class="uk-text-lead">{{__("Selling price")}} (GNF) : <span>{{number_format($details[0]->prix_unitaire)}}</span></li>
					<li  class="uk-text-lead">{{__("Buying price")}} (GNF) : <span>{{number_format($details[0]->prix_achat)}}</span></li>
					<li  class="uk-text-lead">{{__("Pieces")}} : {{$details[1]}}</li>
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
