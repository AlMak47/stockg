@extends('layouts.app_admin')
@section('title')
Add Shop
@endsection
@section('admin_contents')
<div class="uk-container">
	<h3 class="uk-h3">Add User </h3>

		<hr class="uk-divider-small">
		@if($errors->any())
		@foreach($errors->all() as $error)
		<div class="uk-alert-danger uk-border-rounded uk-box-shadow-small" uk-alert>
			<a href="#" class="uk-alert-close" uk-close></a>
			<p>{{$error}}</p>
		</div>
		@endforeach
		@endif

	<!-- FORM ADD USER -->
		<h4 class="uk-h3">User Infos</h4>
		{!!Form::open(['url'=>'admin/add-gerant','id'=>'form-add-gerant'])!!}
			{!!Form::email('email','',['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>'E-mail Adresse'])!!}
			{!!Form::text('phone','',['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>'Telephon Number'])!!}
			{!!Form::select('statut', ['gerant' => 'Simple User'], 'gerant',['class'=>'uk-select uk-margin-small uk-border-rounded'])!!}
			{!!Form::hidden('username',str_random(6))!!}
			{!!Form::hidden('password','stockg')!!}
			{!!Form::hidden('password_confirmation','stockg')!!}
			{!!Form::submit('Ajouter',['class'=>'uk-button uk-button-primary uk-border-rounded uk-box-shadow-small'])!!}
		{!!Form::close()!!}
	<!--  -->
</div>

@endsection
@section('script')
<script type="text/javascript">
	$(function () {
		$("#form-add-gerant").on('submit',function () {
			UIkit.modal("#loading").show()
		})
	})
</script>
@endsection
