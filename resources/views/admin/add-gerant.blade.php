@extends('layouts.app_admin')
@section('title')
Add Shop
@endsection
@section('admin_contents')
<div class="uk-container">
	<h3 class="uk-h1">Add User </h3>
	<ul class="uk-breadcrumb">
	    <li><a href=""><span uk-icon="icon:home"></span></a></li>
	    <li><span>List users</span></li>
	</ul>
		<hr class="uk-divider-small">
		@if($errors->has('email') || $errors->has('phone'))
		<div class="uk-alert uk-alert-danger">
		<div>{{$errors->first('email')}}</div>
		<div>{{$errors->first('phone')}}</div>
		</div>
		@endif

	<!-- FORM ADD USER -->
		<h4 class="uk-h3">User Infos</h4>
		{!!Form::open(['url'=>'admin/add-gerant'])!!}
			{!!Form::email('email','',['class'=>'uk-input uk-margin-small','placeholder'=>'E-mail Adresse'])!!}
			{!!Form::text('phone','',['class'=>'uk-input uk-margin-small','placeholder'=>'Telephon Number'])!!}
			{!!Form::select('statut', ['admin' => 'Administrator', 'gerant' => 'Simple User'], 'gerant',['class'=>'uk-select uk-margin-small'])!!}
			{!!Form::hidden('username',str_random(6))!!}
			{!!Form::hidden('password','stockg')!!}
			{!!Form::hidden('password_confirmation','stockg')!!}
			{!!Form::submit('Ajouter',['class'=>'uk-button uk-button-default'])!!}
		{!!Form::close()!!}
	<!--  -->
</div>

@endsection
