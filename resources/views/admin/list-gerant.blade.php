@extends('layouts.app_admin')
@section('title')
Shop List
@endsection
@section('admin_contents')

<div class="uk-container">
	<h3 class="uk-h3"> List Users </h3>
		<hr class="uk-divider-small">
		@if(session()->has('msg'))
		<div class="uk-alert uk-alert-success">
			<p>
				{{session()->get('msg')}}
			</p>
		</div>
		@endif
		<table class="uk-table uk-table-justify uk-table-responsive uk-table-striped">
	    <thead>
	        <tr>
	            <th>Username</th>
	            <th>Boutique</th>
	            <th>Email</th>
	            <th>Statut</th>
	            <th>Phone</th>
	            <th>Verouiller</th>
	        </tr>
	    </thead>
	    <tbody>
	    		@foreach($ulist as $values)
	    	<tr>
	    		<td>{{$values->username}}</td>
	    		@for($i =0 ;$i < count($boutique) ;$i++)
	    			@if($boutique[$i][0]->users === $values->username)
		    		<td>{{$boutique[$i][0]->localisation}}</td>
	    			@endif
	    		@endfor
	    		<td>{{$values->email}}</td>
	    		<td>{{$values->statut}}</td>
	    		<td>{{$values->phone}}</td>
					@if($values->state == 'unblocked')
	    		<td><a class="bloque-user uk-button uk-text-capitalize uk-button-danger uk-border-rounded" href="#block-user" id="{{$values->username}}" uk-toggle="target: #my-id"><span uk-icon="icon:lock"></span> bloquer</a></td>
					@else
	    		<td><a class="bloque-user uk-button-default uk-button uk-text-capitalize uk-alert-success uk-border-rounded" href="#unblock-user" id="{{$values->username}}" uk-toggle="target: #my-id"><span uk-icon="icon:unlock"></span> debloquer</a></td>
					@endif
	    		<td><a href=""></a></td>
	    	</tr>
	    		@endforeach
	    </tbody>
	</table>
	<!-- admin password confirmations -->
	<div id="my-id" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div class="uk-modal-title">Admin Password</div>
				{!!Form::open(['url'=>'#','id'=>'block-user-form'])!!}
				<input type="hidden" name="username" value="" id="user-id">
				<input type="hidden" name="tag" value="" id="action-tag">
				{!!Form::password('admin_password_confirm',['class'=>'uk-input uk-margin-small uk-border-rounded','id'=>'admin_password_confirm'])!!}
        <button class="uk-button uk-button-primary uk-border-rounded uk-box-shadow-small" type="submit">Confirmer</button>
				{!!Form::close()!!}

    </div>
</div>

</div>

@endsection
@section('script')
<script type="text/javascript">
	$(function () {
		// bloquer un utilisateur
		$(".bloque-user").on('click',function () {
			$("#user-id").val($(this).attr('id'))
			// verifier si le champ password est vide
			if($(this).attr('href') == "#block-user") {
				$("#block-user-form").attr('action',"{{url('admin/list-gerant/block-user')}}")
				$("#action-tag").val('block')
			} else {
				$("#block-user-form").attr('action',"{{url('/admin/list-gerant/unblock-user')}}")
				$("#action-tag").val('unblock')
			}
			$("#block-user-form").on('submit',function(e){
				e.preventDefault()
				UIkit.modal("#loading").show()
				$.ajax({
					url : $(this).attr('action'),
					type : 'post',
					data : $(this).serialize(),
					dataType : 'json',
				})
				.done(function (data) {
					if(data.errors) {
						alert(data.errors)
						$(location).attr('href',"{{url()->current()}}")
					} else {
						alert('success')
						$(location).attr('href',"{{url()->current()}}")
					}
				})
				.fail(function (data) {
					// erreur d'envoi de la request asynchrone
					alert(data.responseJSON.message)
					$(location).attr('href',"{{url()->current()}}")
				})
		})
	});


})
</script>
@endsection
