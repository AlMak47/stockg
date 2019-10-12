@extends('layouts.app_admin')
@section('title')
Dashboard
@endsection
@section('admin_contents')
<div class="uk-container">
	<div class="uk-h3">{{__("Dashboard")}} </div>
	<div class="uk-grid-small uk-child-width-1-2@m uk-child-width-1-4@l" uk-grid>
		<div>
				<div class="uk-card uk-card-default uk-card-primary uk-border-rounded">
			    <div class="uk-card-header">
			        <h4 class="uk-card-title uk-text-center">{{__("COMMANDES")}} <span uk-icon="icon:grid;"></span></h4>
			    </div>
					<div class="uk-card-body">
						<h4 class="uk-h1 uk-text-center">{{$daycommand}}</h4>
					</div>
			</div>
		</div>

		<div>

				<div class="uk-card uk-card-default uk-card-primary uk-border-rounded">
				    <div class="uk-card-header">
				        <h3 class="uk-card-title uk-text-center">CASH (GNF) <span uk-icon="icon:credit-card;"></span></h3>
				    </div>
				    <div class="uk-card-body">
				    	<h4 class="uk-h1 uk-text-center">{{$dcash}}</h4>
				    </div>
				</div>

		</div>

		<div>

				<div class="uk-card uk-card-default uk-card-primary uk-border-rounded">
				    <div class="uk-card-header">
				        <h3 class="uk-card-title uk-text-center">{{__("SHOP")}} <span uk-icon="icon:location;ratio:"></span></h3>
				    </div>
				    <div class="uk-card-body">
				    	<h4 class="uk-h1 uk-text-center">{{$shop}}</h4>
				    </div>
				</div>

		</div>
		<div>

				<div class="uk-card uk-card-default uk-card-primary uk-border-rounded">
				    <div class="uk-card-header">
				        <h3 class="uk-card-title uk-text-center">{{__("ITEMS")}} <span uk-icon="icon:list;ratio:"></span></h3>
				    </div>
				    <div class="uk-card-body">
				    	<h4 class="uk-h1 uk-text-center">{{$items}}</h4>
				    </div>
				</div>

		</div>
	</div>
</div>

@endsection
