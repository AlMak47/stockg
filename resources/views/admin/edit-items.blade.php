@extends('layouts.app_admin')
@section('title')
Edit Item
@endsection
@section('admin_contents')
<div class="uk-container">
	<h3 class="uk-h3">Edit Item</h3>
		<hr class="uk-divider-small">
		@if(session('success'))
		<div class="uk-alert-success uk-border-rounded uk-box-shadow-small" uk-alert>
			<a href="#" class="uk-alert-close" uk-close></a>
			<p>{{session('success')}}</p>
		</div>
		@endif
		@if($errors->any())
		@foreach($errors->all() as $error)
		<div class="uk-alert-danger uk-border-rounded uk-box-shadow-small" uk-alert>
			<a href="#" class="uk-alert-close" uk-close></a>
			<p>{{$error}}</p>
		</div>
		@endforeach
		@endif
		<!-- erreur de traitement -->
		@if(session('_errors'))
		<div class="uk-alert-danger uk-border-rounded uk-box-shadow-small" uk-alert>
			<a href="#" class="uk-alert-close" uk-close></a>
			<div>{{session('_errors')}}</div>
		</div>
		@endif

		{!!Form::open(['url'=>"admin/edit-item/$itemedit->reference",'enctype'=>'multipart/form-data','id'=>'form-edit-item'])!!}
		{!!Form::hidden('reference',$itemedit->reference)!!}
		{!!Form::label("Item *")!!}
		{!!Form::text('libelle',$itemedit->libelle,['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>'Item Name'])!!}
		{!!Form::label("Buying Price *")!!}
		{!!Form::text('prix_achat',$itemedit->prix_achat,['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>'Prix achat'])!!}
		{!!Form::label("Selling Price *")!!}
		{!!Form::text('prix_unitaire',$itemedit->prix_unitaire,['class'=>'uk-input uk-margin-small uk-border-rounded','placeholder'=>'Unit Price'])!!}
		<img src="{{asset('uploads/'.$itemedit->image)}}" class="uk-width-small" uk-img>
		<div class="uk-margin-small">
			{!!Form::label("Remplace Image *")!!}
      <div uk-form-custom>
				{!!Form::file('image')!!}
          <button class="uk-button-primary uk-padding-small uk-border-circle uk-icon-link" uk-icon="icon:image" type="button" tabindex="-1"></button>
      </div>
		</div>
		{!!Form::submit('Envoyer',['class'=>'uk-button uk-button-primary uk-border-rounded uk-box-shadow-small'])!!}
		{!!Form::close()!!}

</div>

@endsection
@section('script')
<script type="text/javascript">
	$(function () {
		$("#form-edit-item").on('submit',function () {
			UIkit.modal("#loading").show()
		})
	})
</script>
@endsection
