@extends('layouts.app_admin')
@section('title')
{{__("Add Item")}}
@endsection
@section('admin_contents')
<div class="uk-container uk-container-small">
	<h3 class="uk-h3">{{__("Add Item")}}</h3>
		<hr class="uk-divider-small">

		<div class="uk-alert uk-alert-info uk-box-shadow-small uk-border-rounded" id="info-exist" style="display: none;">
			<p><span uk-icon="icon:info;ratio:1.2"></span> {{__("This Product Already exists! To add a stock, just enter the quantity")}}</p>
		</div>

		@if(session('success'))
		<div class="uk-alert uk-alert-success">
			{{session('success')}}
		</div>
		@endif
		@if(session('error'))
		<div class="uk-alert uk-alert-danger">
			{{session('error')}}
		</div>
		@endif
		<!-- errors messages -->
		@if($errors->any())
		@foreach($errors->all() as $error)
		<div class="uk-alert-danger uk-box-shadow-small uk-border-rounded" uk-alert>
			<a href="#" class="uk-alert-close" uk-close></a>
			<p>{{$error}}</p>
		</div>
		@endforeach
		@endif
		<div class="uk-alert-info uk-box-shadow-small uk-border-rounded" uk-alert>
			<a href="#" class="uk-alert-close" uk-close></a>
			<p>(*) {{__('Champs Obligatoires')}}</p>
		</div>
		{!!Form::open(['url'=>'admin/add-item','enctype'=>'multipart/form-data','id'=>'add-form'])!!}
		{!!Form::label('Shop *')!!}
		<select name="boutiques" class="uk-select uk-border-rounded uk-margin-small">
			<option value="">--{{__("Select Shop")}}--</option>
			@foreach($bouti as $values)
			<option value="{{$values->localisation}}">{{$values->localisation}}</option>
			@endforeach
		</select>
		{!!Form::hidden('reference','IT'.time())!!}
		{!!Form::label(__("Item Name").' *')!!}
		{!!Form::text('libelle',null,['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>__("Item Name"),'id'=>'item-name'])!!}
		{!!Form::label('prix_achat',__("Buying Price")."*",['class'=>'zone-hide'])!!}
		{!!Form::text('prix_achat',0,['class'=>'uk-input uk-margin-small zone-hide uk-border-rounded','placeholder'=>__('Buying Price'),'id'=>'prix-achat'])!!}
		{!!Form::label('prix_unitaire',__('Unit Price')."*",['class'=>'zone-hide'])!!}
		{!!Form::text('prix_unitaire',0,['class'=>'uk-input uk-margin-small zone-hide uk-border-rounded','placeholder'=>__("Unit Price"),'id'=>'prix-unitaire'])!!}
		{!!Form::label(__("Quantity")."*")!!}
		{!!Form::number('quantite',null,['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>__("Quantity"),'id'=>'quantity'])!!}
		<div class="uk-margin-small">
			{!!Form::label(__("Select Image")."*")!!}
      <div uk-form-custom>
				{!!Form::file('image')!!}
          <button class="uk-button-primary uk-padding-small uk-border-circle uk-icon-link" uk-icon="icon:image" type="button" tabindex="-1"></button>
      </div>
		</div>
		<div class="uk-visible@m">
			{!!Form::submit(__("Submit"),['class'=>'uk-button uk-button-primary uk-border-rounded uk-box-shadow-small'])!!}
		</div>
		<div class="uk-hidden@m">
			{!!Form::submit(__("Submit"),['class'=>'uk-button uk-button-primary uk-width-1-1 uk-border-rounded uk-box-shadow-small'])!!}
		</div>
		{!!Form::close()!!}

</div>

@endsection
@section('admin_script')
<script type="text/javascript">
	$(function() {
		// traitement de l'ajout du produit
		$("#item-name").on('keyup focus blur',function () {
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
						if(data && data !== 'fail') {
							console.log(data)
							// le produit existe il faut donc cacher les autres champs
							$("#prix-achat").val(data.prix_achat)
							$("#prix-unitaire").val(data.prix_unitaire)
							$(".zone-hide").hide();
							$("#info-exist").show(500);
							// $("#img").val('kk');
							// $("#add-form").removeAttr('enctype');
						} else {
							// Le produit n'existe pas la procedure habituelle continu
							// $("#add-form").addAttr('enctype','mulipart/formdata');
							$(".zone-hide").show();
						}
					})
					.fail(function(data){
						console.log(data);
					})
				});
				form.submit();

		});

		$("#add-form").on('submit',function () {
			UIkit.modal("#loading").show()
		})

	});
</script>
@endsection
