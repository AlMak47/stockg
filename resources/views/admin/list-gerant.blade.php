@extends('layouts.app_admin')

@section('admin_contents')

<div class="uk-container">
	<h3 class="uk-h1"><span uk-icon="icon:users;ratio:2"></span> List Users <span class="uk-h4 uk-align-right"><span uk-icon="icon:calendar"></span> {{$date}}</span></h3>
	<ul class="uk-breadcrumb">
	    <li><a href=""><span uk-icon="icon:home"></span></a></li>
	    <li><span>List users</span></li>
	</ul>
		<hr class="uk-divider-small">
		@if(session()->has('msg')) 
		<div class="uk-alert uk-alert-success">
			<p>
				{{session()->get('msg')}}
			</p>
		</div>
		@endif
		<table class="uk-table uk-table-justify uk-table-divider">
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
	    		<td><a href=""><span uk-icon="icon:lock"></span> bloquer</a></td>
	    		<td><a href=""></a></td>
	    	</tr>
	    		@endforeach
	    </tbody>
	</table>
</div>

@endsection