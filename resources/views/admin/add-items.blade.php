@extends('layouts.app_admin')

@section('admin_contents')
<div class="uk-container">
	<h3 class="uk-h1">Add to Stock <span class="uk-h4 uk-align-right"><span uk-icon="icon:calendar"></span> {{$date}}</span></h3>
	<ul class="uk-breadcrumb">
	    <li><a href=""><span uk-icon="icon:home"></span></a></li>
	    <li><span>Add to Stock</span></li>
	</ul>
		<hr class="uk-divider-small">

		<div class="uk-alert uk-alert-info" id="info-exist" style="display: none;">
			<p><span uk-icon="icon:info;ratio:1.2"></span> Ce Produit Existe deja ! Pour l'ajouter a un stock , saisissez juste la quantite</p>
		</div>

		@if(session('success'))
		<div class="uk-alert uk-alert-success">
			{{session('success')}}
		</div>
		@endif
		<!-- errors messages -->
		@if($errors->has('boutiques') || $errors->has('libelle') || $errors->has('prix_achat') || $errors->has('prix_unitaire') || $errors->has('quantite') || $errors->has('image'))
		<div class="uk-alert uk-alert-danger">
			<div>{{$errors->first('libelle')}}</div>
			<div>{{$errors->first('prix_achat')}}</div>
			<div>{{$errors->first('prix_unitaire')}}</div>
			<div>{{$errors->first('quantite')}}</div>
			<div>{{$errors->first('image')}}</div>
			<div>{{$errors->first('boutiques')}}</div>
		</div>
		@endif

		{!!Form::open(['url'=>'admin/add-item','enctype'=>'multipart/form-data'])!!}
		<select name="boutiques" class="uk-select">
			<option value="">--Select Boutique--</option>
			@foreach($bouti as $values)
			<option value="{{$values->localisation}}">{{$values->localisation}}</option>
			@endforeach
		</select>
		{!!Form::hidden('reference','IT'.time())!!}
		{!!Form::text('libelle',null,['class'=>'uk-input uk-margin-small','placeholder'=>'Item Name','id'=>'item-name'])!!}
		{!!Form::text('prix_achat',null,['class'=>'uk-input uk-margin-small zone-hide','placeholder'=>'Prix achat'])!!}
		{!!Form::text('prix_unitaire',null,['class'=>'uk-input uk-margin-small zone-hide','placeholder'=>'Unit Price'])!!}
		{!!Form::number('quantite',null,['class'=>'uk-input uk-margin-small','placeholder'=>'Quantity'])!!}
		<div>{!!Form::file('image',['class'=>'uk-margin-small zone-hide'])!!}</div>
		{!!Form::submit('Envoyer',['class'=>'uk-button uk-button-default'])!!}
		{!!Form::close()!!}
		
</div>

@endsection
@section('admin_script')
<script type="text/javascript">
	$(function() {
		// traitement de l'ajout du produit 
		$("#item-name").on('keyup',function () {

			// console.log($(this).val());
			// envoi d'une requete ajax
			var form = $adminPage.makeForm("{{csrf_token()}}","/admin/add-item/simplify",$("#item-name").val());
				form.on('submit',function (e) {
					e.preventDefault();
					$.ajax({
						url : $(this).attr('action'),
						type : $(this).attr('method'),
						data : $(this).serialize(),
						dataType : 'json'
					})
					.done(function (data) {
						if(data && data == 'done') {
							// le produit existe il faut donc cacher les autres champs
							$(".zone-hide").hide();
							$("#info-exist").show(500);

						} else if(data && data == 'fail') {
							// Le produit n'existe pas la procedure habituelle continu
							$(".zone-hide").show();
						}
					})
					.fail(function(data){
						console.log(data);
					})
				});
				form.submit();

		});

	});
</script>
@endsection