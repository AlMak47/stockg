@extends('layouts.app_admin')
@section('title')
List Item
@endsection
@section('admin_contents')

<div class="uk-container">
	<h3 class="uk-h3">List Items</h3>
		<hr class="uk-divider-small">
		<div class="uk-child-width-1-2@m" uk-grid>
			<div>
				<h1 class="uk-h5"><span uk-icon="icon:location;ratio:0.7"></span> Filter by Shop</h1>
				{!!Form::open(['id'=>'filterForm'])!!}
				{!!Form::close()!!}
				<select name="boutique" class="uk-select uk-border-rounded" id="filter-by-boutique">
					<option value="all">All</option>
					@foreach($boutiques as $values)
					<option value="{{$values->localisation}}">{{$values->localisation}}</option>
					@endforeach
				</select>

			</div>
			<div>
				<h1 class="uk-h5"><span uk-icon="icon:search;ratio:0.7"></span> Search</h1>
				{!!Form::search('search','',['class'=>'uk-input uk-border-rounded','placeholder'=>'Search','id'=>'search'])!!}
			</div>
	</div>
		<!-- <div class="loader" uk-spinner></div> -->
		<table class="uk-table uk-table-justify uk-table-striped" >
	    <thead>
	        <tr>
	            <th>Item</th>
	            <th>Quantite</th>
	            <th>PU (GNF)</th>
	            <th>PA (GNF)</th>
	            <th>Image</th>
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
				error:function (data) {
					alert(data.responseJSON.message)
				},
				success:function (sdata) {
					loading.remove();
					$adminPage.createTableRow(sdata,['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"));
					$adminPage.showImage();
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
				$adminPage.getDataFormAjax($(this).val(),"{{csrf_token()}}",'list-item',['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"),1);
				loading.remove();
				// $adminPage.createTableRow();
				// recherche rapide
				$("#search").on('keyup',function() {
					$adminPage.findItem("{{csrf_token()}}","{{url()->current()}}/search-item",$("#filter-by-boutique").val(),$(this).val());
				});
				// ===
			} else {
				$("#filterForm").submit();

			}
		});
		// recherche rapide
		$("#search").on('keyup',function() {
			$adminPage.findItem("{{csrf_token()}}","{{url()->current()}}/search-item",'',$(this).val());
		});


	});
</script>
@endsection
