@extends('layouts.app_admin')

@section('title')
Settings
@endsection

@section('admin_contents')

<div class="uk-container">
	<h3 class="uk-h3">Profile</h3>

		<hr class="uk-divider-small">

		<div class="uk-margin-remove uk-padding-remove">
			<div class="uk-grid-small uk-child-width-1-1@m" uk-grid>

				<div class="">
				<div class="uk-card uk-card-default uk-border-rounded uk-box-shadow-small">
					<div class="uk-card-header">Profile Infos</div>
					<div class="uk-card-body">
						<!-- <a href="" class="uk-button uk-button-link"><span uk-icon="icon:pencil"></span> Edit</a> -->
						<ul class="uk-list uk-list-divider">
							<li><span uk-icon="icon:user;ratio:0.9"></span> Username : {{Auth::user()->username}}</li>
							<li><span uk-icon="icon:mail;ratio:0.9"></span> Email : {{Auth::user()->email}}</li>
							<li><span uk-icon="icon:phone;ratio:0.9"></span> Phone : {{Auth::user()->phone}}</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="">

				<div class="uk-card uk-card-default uk-border-rounded uk-box-shadow-small">
					<div class="uk-card-header">Change password</div>
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
						{!!Form::open(['url'=>url()->current(),'id'=>'form-profile'])!!}
						{!!Form::text('old_password','',['class'=>'uk-input uk-margin-small','placeholder'=>'Old Password'])!!}
						{!!Form::password('new_password',['class'=>'uk-input uk-margin-small','placeholder'=>'New Password'])!!}
						{!!Form::password('new_password_confirmation',['class'=>'uk-input uk-margin-small','placeholder'=>'Confirm new password'])!!}
						{!!Form::submit('Envoyer',['class'=>'uk-button uk-button-primary uk-border-rounded uk-box-shadow-small uk-visible@m'])!!}
						{!!Form::submit('Envoyer',['class'=>'uk-button uk-button-primary uk-border-rounded uk-box-shadow-small uk-width-1-1 uk-hidden@m'])!!}
						{!!Form::close()!!}
					</div>
				</div>
			</div>
			</div>
		</div>

<!-- <input type="hidden" id="token" value="{{csrf_token()}}"> -->
@endsection
@section('script')
<script type="text/javascript">

	$(function() {
		$("#form-profile").on('submit',function () {
			UIkit.modal("#loading").show()
		})
	});
</script>
@endsection
