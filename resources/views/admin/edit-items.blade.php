@extends('layouts.app_admin')

@section('admin_contents')
<div class="uk-container">
	<h3 class="uk-h1">Edit Item <span class="uk-h4 uk-align-right"><span uk-icon="icon:calendar"></span> {{$date}}</span></h3>
	<ul class="uk-breadcrumb">
	    <li><a href="{{url('/admin/list-item/')}}"><span uk-icon="icon:home"></span></a></li>
	    <li><span>Edit Item</span></li>
	</ul>
		<hr class="uk-divider-small">
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
		<!-- erreur de traitement -->
		@if(session('_errors')) 
		<div class="uk-alert uk-alert-danger">
			<div>{{session('_errors')}}</div>
		</div>
		@endif

		{!!Form::open(['url'=>"admin/edit-item/$itemedit->reference",'enctype'=>'multipart/form-data'])!!}
		{!!Form::hidden('reference',$itemedit->reference)!!}
		{!!Form::text('libelle',$itemedit->libelle,['class'=>'uk-input uk-margin-small','placeholder'=>'Item Name'])!!}
		{!!Form::text('prix_achat',$itemedit->prix_achat,['class'=>'uk-input uk-margin-small','placeholder'=>'Prix achat'])!!}
		{!!Form::text('prix_unitaire',$itemedit->prix_unitaire,['class'=>'uk-input uk-margin-small','placeholder'=>'Unit Price'])!!}
		<img src="{{asset('uploads/'.$itemedit->image)}}" class="uk-width-small" uk-img>
		<div>{!!Form::file('image',['class'=>'uk-margin-small'])!!}</div>
		{!!Form::submit('Envoyer',['class'=>'uk-button uk-button-default'])!!}
		{!!Form::close()!!}
		
</div>

@endsection