@extends('layouts.app_admin')
@section('title')
{{__("Add Shop")}}
@endsection
@section('admin_contents')
<div class="uk-container">
	<h3 class="uk-h3">{{__("Add User")}} </h3>

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
		<h4 class="uk-h3">{{__("User Infos")}}</h4>
		{!!Form::open(['url'=>'admin/add-gerant','id'=>'form-add-gerant'])!!}
			{!!Form::label('email',__("Email")." *")!!}
			{!!Form::email('email','',['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>__("Email")])!!}
			{!!Form::label('phone_number',__("Telephon Number")." *")!!}
			{!!Form::text('phone','',['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>_("Telephone Number")])!!}
			{!!Form::select('statut', ['gerant' => 'Simple User'], 'gerant',['class'=>'uk-select uk-margin-small uk-border-rounded'])!!}
			{!!Form::hidden('username',str_random(6))!!}
			{!!Form::hidden('password','stockg')!!}
			{!!Form::hidden('password_confirmation','stockg')!!}
			{!!Form::submit(__("Submit"),['class'=>'uk-button uk-button-primary uk-border-rounded uk-box-shadow-small uk-visible@m'])!!}
			{!!Form::submit(__("Submit"),['class'=>'uk-button uk-button-primary uk-border-rounded uk-box-shadow-small uk-width-1-1 uk-hidden@m'])!!}
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
