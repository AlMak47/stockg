@extends('layouts.template')

@section('content')
<div class="uk-container">
	<h3 class="uk-h1">Complete Registration <span class="uk-h4 uk-align-right"><span uk-icon="icon:calendar"></span> {{$date}}</span></h3>
	<ul class="uk-breadcrumb">
	    <li><a href=""><span uk-icon="icon:home"></span></a></li>
	    <li><span>add boutique</span></li>
	</ul>
		<hr class="uk-divider-small">
		@if($errors->has('email') || $errors->has('phone') || $errors->has('localisation'))
		<div class="uk-alert uk-alert-danger">
		<div>{{$errors->first('email')}}</div>
		<div>{{$errors->first('phone')}}</div>
		<div>{{$errors->first('localisation')}}</div>
		</div>
		@endif
	<!-- FORM ADD BOUTIQUE -->
		<h4 class="uk-h3">Boutique Infos</h4>
		{!!Form::open(['url'=>'admin/add-boutique'])!!}
			{!!Form::hidden('username',$user->username)!!}
			{!!Form::text('localisation','',['class'=>'uk-input uk-margin-small','placeholder'=>'Nom du magazin'])!!}
			{!!Form::submit('Ajouter',['class'=>'uk-button uk-button-default'])!!}
		{!!Form::close()!!}
	<!--  -->
</div>

@endsection