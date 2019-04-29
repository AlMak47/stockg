@extends('layouts.app_gerant')

@section('gerant_contents')
<div class="uk-container">
	<h3 class="uk-h1">Profile <span class="uk-align-right uk-h4"><span uk-icon="icon:location;ratio:0.8"></span> {{$boutique}} </span>
		<span class="uk-h4 uk-align-right">{{$date}}</span></h3>
</div>
<!-- TOUS LES PRODUITS -->

<div class="uk-container">
	<ul class="uk-breadcrumb">
	    <li><a href=""><span uk-icon="icon:home"></span></a></li>
	    <li><span>List Items</span></li>
	</ul>

		<hr class="uk-divider-small">

		<div class="uk-section uk-section-default uk-margin-remove uk-padding-remove">
			<div class="uk-grid-match uk-child-width-1-2@m" uk-grid>
				<div class="uk-card">
					<h3 class="uk-card-header">Profile Infos</h3>
					<div class="uk-card-body">
						<ul class="uk-list uk-list-divider">
							<li><span uk-icon="icon:user;ratio:0.9"></span> Username : {{Auth::user()->username}}</li>
							<li><span uk-icon="icon:mail;ratio:0.9"></span> Email : {{Auth::user()->email}}</li>
							<li><span uk-icon="icon:phone;ratio:0.9"></span> Phone : {{Auth::user()->phone}}</li>
						</ul>
					</div>
				</div>
				<div class=" uk-card">
					<h3 class="uk-card-header">Change password</h3>
					
					<div class="uk-card-body">
						@if($errors->has('old_password') || $errors->has('new_password'))
						<div class="uk-alert uk-alert-danger">
							<div>{{$errors->first('old_password')}}</div>
							<div>{{$errors->first('new_password')}}</div>
						</div>
						@endif
						@if(session()->has('error'))
						<div class="uk-alert uk-alert-danger">
							<p>
								{{session()->get('error')}}
							</p>
						</div>
						@endif
						@if(session()->has('success'))
						<div class="uk-alert uk-alert-success">
							<p>
								{{session()->get('success')}}
							</p>
						</div>
						@endif
						{!!Form::open()!!}
						{!!Form::text('old_password','',['class'=>'uk-input uk-margin-small','placeholder'=>'Old Password'])!!}
						{!!Form::password('new_password',['class'=>'uk-input uk-margin-small','placeholder'=>'New Password'])!!}
						{!!Form::password('new_password_confirmation',['class'=>'uk-input uk-margin-small','placeholder'=>'Confirm new password'])!!}
						{!!Form::submit('Envoyer',['class'=>'uk-button uk-button-default'])!!}
						{!!Form::close()!!}
					</div>
				</div>
			</div>
		</div>
		
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
		// $adminPage.getListCommand("{{csrf_token()}}","{{url()->current()}}",''); 

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