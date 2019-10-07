@extends('layouts.app_gerant')
@section('title')
Settings
@endsection
@section('gerant_contents')

<div class="uk-container">
	<h3 class="uk-h3">Profile</h3>
		<hr class="uk-divider-small">

		<div class="">
			<div class="uk-grid-small uk-child-width-1-1@m" uk-grid>
				<div class="uk-card uk-card-default uk-border-rounded uk-box-shadow-small">
					<h3 class="uk-card-header">Profile Infos</h3>
					<div class="uk-card-body">
						<ul class="uk-list uk-list-divider">
							<li><span uk-icon="icon:user;ratio:0.9"></span> Username : {{Auth::user()->username}}</li>
							<li><span uk-icon="icon:mail;ratio:0.9"></span> Email : {{Auth::user()->email}}</li>
							<li><span uk-icon="icon:phone;ratio:0.9"></span> Phone : {{Auth::user()->phone}}</li>
						</ul>
					</div>
				</div>
				<div class=" uk-card uk-card-default uk-border-rounded uk-box-shadow-small">
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
						{!!Form::text('old_password','',['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>'Old Password'])!!}
						{!!Form::password('new_password',['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>'New Password'])!!}
						{!!Form::password('new_password_confirmation',['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>'Confirm new password'])!!}
						{!!Form::submit('Envoyer',['class'=>'uk-button uk-button-primary uk-border-rounded uk-box-shadow-small uk-width-1-1@s uk-width-1-6@m'])!!}
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
