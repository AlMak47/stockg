@extends('layouts.app_admin')
@section('title')
Dashboard
@endsection
@section('admin_contents')
<div class="uk-container">
	<h3 class="uk-h1">Dashboard <span class="uk-h4 uk-align-right"><span uk-icon="icon:calendar"></span> {{$date}}</span></h3>
	<div class="uk-child-width-1-2@m" uk-grid>
		<div>

				<div class="uk-card uk-card-primary">
			    <div class="uk-card-header">
			        <h3 class="uk-card-title uk-text-center">COMMANDES <span uk-icon="icon:grid;ratio:3"></span></h3>
			    </div>
			    <div class="uk-card-body">
			    	<h4 class="uk-h1 uk-text-center">{{$daycommand}}</h4>
			    </div>
			</div>

		</div>

		<div>

				<div class="uk-card uk-card-primary">
				    <div class="uk-card-header">
				        <h3 class="uk-card-title uk-text-center">CASH (GNF) <span uk-icon="icon:credit-card;ratio:3"></span></h3>
				    </div>
				    <div class="uk-card-body">
				    	<h4 class="uk-h1 uk-text-center">{{$dcash}}</h4>
				    </div>
				</div>

		</div>

		<div>

				<div class="uk-card uk-card-primary">
				    <div class="uk-card-header">
				        <h3 class="uk-card-title uk-text-center">SHOP <span uk-icon="icon:location;ratio:3"></span></h3>
				    </div>
				    <div class="uk-card-body">
				    	<h4 class="uk-h1 uk-text-center">{{$shop}}</h4>
				    </div>
				</div>

		</div>
		<div>

				<div class="uk-card uk-card-primary">
				    <div class="uk-card-header">
				        <h3 class="uk-card-title uk-text-center">ITEMS <span uk-icon="icon:list;ratio:3"></span></h3>
				    </div>
				    <div class="uk-card-body">
				    	<h4 class="uk-h1 uk-text-center">{{$items}}</h4>
				    </div>
				</div>

		</div>
	</div>
</div>

@endsection
