@extends('layouts.app_admin')

@section('title')
Entree stock
@endsection

@section('admin_contents')

<div class="uk-container">
	<h3 class="uk-h1"><span uk-icon="icon:thumbnails;ratio:2"></span> List Entree <span class="uk-h4 uk-align-right"><span uk-icon="icon:calendar"></span> {{$date}}</span></h3>
	<ul class="uk-breadcrumb">
	    <li><a href=""><span uk-icon="icon:home"></span></a></li>
	    <li><span>List Entree</span></li>
	</ul>
		<hr class="uk-divider-small">
		<div class="uk-child-width-1-2@m" uk-grid>
			<div>
				<h1 class="uk-h5"><span uk-icon="icon:location;ratio:0.7"></span> Filter by Boutique</h1>
				{!!Form::open(['id'=>'filterForm'])!!}
				{!!Form::close()!!}
				<select name="boutique" class="uk-select" id="filter-by-boutique">
					<option value="all">All</option>
					@foreach($boutiques as $values)
					<option value="{{$values->localisation}}">{{$values->localisation}}</option>
					@endforeach
				</select>

			</div>
			<div>
				<h1 class="uk-h5"><span uk-icon="icon:search;ratio:0.7"></span> Search</h1>
				{!!Form::search('search','',['class'=>'uk-input','placeholder'=>'Search','id'=>'search'])!!}
			</div>
	</div>
		<!-- <div class="loader" uk-spinner></div> -->
		<table class="uk-table uk-table-justify uk-table-divider" >
	    <thead>
	        <tr>
	            <th>Libelle</th>
	            <th>Quantite</th>
	            <th>Date</th>
	            <th>PU (GNF)</th>
	            <th>PA (GNF)</th>
	            <th>Photo</th>
	            <th colspan="2">-</th>
	        </tr>
	    </thead>
	    <tbody id="list-item" class=""></tbody>
	</table>
</div>

@endsection
@section('script')
<script type="text/javascript">
		 // qt;


	$(function () {
		var loading = $("<div></div>");loading.attr('uk-spinner','');

		 // liste=null;
		$("#filterForm").on('submit',function(e) {
			$("#list-item > tbody").html('');
			loading.insertBefore($('#list-item'));
			e.preventDefault();
			$.ajax({
				url :$(this).attr('action'),
				type : $(this).attr('method'),
				dataType : 'json',
				data :$(this).serialize(),
				error:function () {console.log('error');},
				success:function (sdata) {
					// console.log(sdata);
					loading.remove();
					$adminPage.createTableRow(sdata,['libelle','quantite','date','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"));
					$adminPage.showImage();
					$('.edit-button').hide();
				}
			});

		});
		$("#filterForm").submit();

		// FILTER BY BOUTIQUE
		$("#filter-by-boutique").on('change',function () {
			// console.log($("#list-item"));
			console.log($("#filter-by-boutique").val());
			if($(this).val() !== "all") {
				loading.insertBefore($('#list-item'));
				$("#list-item > tbody").html('');
				$adminPage.getDataFormAjax($(this).val(),"{{csrf_token()}}",'entree',['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"),1);
				loading.remove();

				// $adminPage.createTableRow();
				// recherche rapide
				// $("#search").on('keyup',function() {
				// 	$adminPage.findItem("{{csrf_token()}}","{{url()->current()}}/search-item",$("#filter-by-boutique").val(),$(this).val());
				// });
				// ===
			} else {
				$("#filterForm").submit();
			}
		});
		// recherche rapide
		// $("#search").on('keyup',function() {
		// 	$adminPage.findItem("{{csrf_token()}}","{{url()->current()}}/search-item",'',$(this).val());
		// });


	});
</script>
@endsection
