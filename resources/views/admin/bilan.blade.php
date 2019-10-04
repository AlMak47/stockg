@extends('layouts.app_admin')

@section('admin_contents')

<div class="uk-container">
	<h3 class="uk-h1"><span uk-icon="icon:history;ratio:2"></span> Bilan <span class="uk-h4 uk-align-right"><span uk-icon="icon:calendar"></span> {{$date}}</span></h3>
</div>
<!-- TOUS LES PRODUITS -->

<div class="uk-container">
	<ul class="uk-breadcrumb">
	    <li><a href=""><span uk-icon="icon:home"></span></a></li>
	    <li><span>Bilan</span></li>
	</ul>

		<hr class="uk-divider-small">
		<div class="uk-child-width-1-2@m" uk-grid>
			<div>
						<!-- filter by boutique -->
						<h1 class="uk-h5"><span uk-icon="icon:location;ratio:0.7"></span> Filter by Boutique</h1>
					<select name="boutique" class="uk-select" id="filter-by-boutique">
						<option value="all">All</option>
						@foreach($boutiques as $values)
						<option value="{{$values->localisation}}">{{$values->localisation}}</option>
						@endforeach
					</select>
				</div>
			<div>
					<h1 class="uk-h5"><span uk-icon="icon:calendar;ratio:0.7"></span> Filter by date</h1>
					{!!Form::open(['url'=>'/admin/bilan/by-date','class'=>'uk-grid-small','uk-grid','id'=>'filter-date'])!!}
					<div class="uk-width-2-5@s">
						{!!Form::text('date_depart',null,['class'=>'uk-input select_date','placeholder'=>'Du','id'=>'date_depart'])!!}
					</div>
					<div class="uk-width-2-5@s">
						{!!Form::text('date_fin',null,['class'=>'uk-input select_date','placeholder'=>'Au','id'=>'date_fin'])!!}
					</div>
					<div class="uk-width-1-5@s">
					{!!Form::submit('Ok',['class'=>'uk-button uk-button-default'])!!}
					</div>

					{!!Form::close()!!}
				</div>
		</div>
		<hr class="uk-divider-small">
		<div class="loading" style="display:none;" uk-spinner></div>
		<div class="c-values uk-child-width-1-1@m" uk-grid>
			<div>
				<div class="uk-grid-small" uk-grid>
				    <div class="uk-width-expand uk-h3" uk-leader="fill: _">STOCK (GNF)</div>
				    <div class="uk-text-lead" id="in-stock">{{number_format($totalinstock)}}</div>
				</div>
				<div class="uk-grid-small" uk-grid>
				    <div class="uk-width-expand uk-h3" uk-leader="fill: _">VENDU (GNF)</div>
				    <div class="uk-text-lead" id="vendu">{{number_format($dayvalue)}}</div>
				</div>
				<div class="uk-grid-small" uk-grid>
				    <div class="uk-width-expand uk-h3" uk-leader="fill: _">BENEFICE (GNF)</div>
				    <div class="uk-text-lead" id="interet">{{number_format($interet)}}</div>
				</div>
				<div class="uk-grid-small" uk-grid>
				    <div class="uk-width-expand uk-h3" uk-leader="fill: _">ENTREE (GNF)</div>
				    <div class="uk-text-lead" id="entree">{{number_format($entree)}}</div>
				</div>
			</div>
			<div>

			</div>
		</div>

</div>
<!-- <input type="hidden" id="token" value="{{csrf_token()}}"> -->
@endsection
@section('script')
<script type="text/javascript">

	$(function() {

		$('.select_date').datepicker({
			  dateFormat: "yy-mm-dd"
			});

			// filtrer par interval de date
			var _form = $("#filter-date")

			_form.on('submit',function (e) {
				e.preventDefault()

				$.ajax({
					url : $(this).attr('action'),
					type : 'post',
					dataType : 'json',
					data : $(this).serialize() + "&boutique=" + $("#filter-by-boutique").val()
				})
				.done(function (data) {
					$("#in-stock").html(data.inStock);
					$("#vendu").html(data.vendu);
					$("#interet").html(data.interet);
					$("#entree").html(data.entree);
				})
				.fail(function (data) {
					console.log(data)
				})
			})

		// FILTRER LE BILAN PAR BOUTIQUE

		$("#filter-by-boutique").on('change',function() {
			// if($(this).val() == "all") {
			// 	$(location).attr('href','');
			// }
			var form = $adminPage.makeForm("{{csrf_token()}}","{{url()->current()}}",$(this).val());

			form.on('submit',function (e) {
				e.preventDefault();
				$.ajax({
					url : $(this).attr('action'),
					type : $(this).attr('method'),
					dataType : 'json',
					data : $(this).serialize()
				})
				.done(function(data) {
					console.log(data);
					$("#in-stock").html(data.inStock);
					$("#vendu").html(data.vendu);
					$("#interet").html(data.interet);
					$("#entree").html(data.entree);
				})
				.fail(function (data) {
					console.log(data);
				});
			});
			form.submit();
		});

		$(document).ajaxStart(function () {
			$(".loading").show();
		})
		$(document).ajaxSuccess(function () {
			$(".loading").hide();
		})
		//
		$(".c-values > div").addClass('uk-padding-small');
	});
</script>
@endsection
