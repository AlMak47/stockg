<!DOCTYPE html>
<html>
<head>
	<title>{{config('app.name')}}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/png" />
		 <!-- UIkit CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/css/uikit.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />
</head>
<body>

<nav class="uk-navbar-container uk-box-shadow-small" uk-sticky style="background:rgba(255,255,255,1) !important"  uk-navbar>



	    <div class="uk-navbar-left uk-hidden@m">
	        <a class="uk-navbar-toggle" uk-toggle="target: #mobile-menu" href="#">
	            <span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Menu</span>
	        </a>
	    </div>
<!-- OFF CANVAS -->
	    <div id="mobile-menu" uk-offcanvas="push">
	        <div class="uk-offcanvas-bar">

	            <!-- <button class="uk-offcanvas-close" type="button" uk-close></button> -->
	            <ul class="uk-nav uk-nav-default">
		            <li><a href="{{url('/')}}"><span uk-icon="icon:home"></span> Dashboard</a></li>
			                @if(Auth::user()->statut!=="gerant")
			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:thumbnails"></span> Produits</a>
			            <ul class="uk-nav-sub">
			            	  <!-- RESERVER A L'AMINISTRATEUR -->
			                <li><a href="{{url('admin/add-item')}}"><span uk-icon="icon:plus"></span> Add</a></li>
			                <li><a href="{{url('admin/list-item')}}"><span uk-icon="icon:list"></span> List</a></li>
			            </ul>
			        </li>
			                @endif
			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:grid"></span> Command</a>
			            <ul class="uk-nav-sub">
			            	<!-- USERS ONLY -->
			            	@if(Auth::user()->statut==="gerant")
			                <li><a href="{{url('gerant/command/add')}}"><span uk-icon="icon:plus"></span> Add</a></li>
			                <li><a href="{{url('gerant/command/list')}}"><span uk-icon="icon:list"></span> List</a></li>
			                @endif
			                <!-- // -->
			                @if(Auth::user()->statut!=="gerant")
			                <li><a href="{{url('admin/list-command')}}"><span uk-icon="icon:list"></span> List</a></li>
			                @endif
			            </ul>
			        </li>
			        <!-- ADMIN ONLY -->
			        @if(Auth::user()->statut!=="gerant")
			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:users"></span> Gerants</a>
			            <ul class="uk-nav-sub">
			                <li><a href="{{url('/admin/list-gerant')}}"><span uk-icon="icon:list"></span> List</a></li>
			                <li><a href="{{url('/admin/add-gerant')}}"><span uk-icon="icon:plus"></span> Add</a></li>
			            </ul>
			        </li>
			        <li class="uk-parent">
			        	<a href="#"><span uk-icon="icon:history"></span> Bilan</a>
			        	<ul class="uk-nav-sub">
			        		<li><a href="{{url('admin/bilan')}}"><span uk-icon="icon:minus"></span> Voir le bilan</a></li>
			        		<li><a href="{{url('admin/entree')}}"><span uk-icon="icon:minus"></span> Liste des entrees</a></li>
			        	</ul>
			        </li>
			        @endif
			        <!-- // -->

			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:settings"></span> Parametres</a>
			            <ul class="uk-nav-sub">
			            	<!-- USERS ONLY -->
			            	@if(Auth::user()->statut==="gerant")
			                <li><a href="{{url('gerant/profile')}}"><span uk-icon="icon:user"></span> Profile</a></li>
			                @endif
			                @if(Auth::user()->statut!=="gerant")
			                <li><a href="{{url('admin/profile')}}"><span uk-icon="icon:user"></span> Profile</a></li>
			                @endif
			                {!!Form::open(['url'=>'/logout'])!!}
			                <li><button type="submit" class="uk-button uk-button-link" href="{{url('logout')}}"><span uk-icon="icon:sign-out"></span> Logout</button></li>
			                {!!Form::close()!!}
			            </ul>
			        </li>
		        </ul>

	        </div>
	    </div>
<!-- // -->
    <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li><a>
            	<span class="uk-visible@m"><img src="{{asset('img/logo.png')}}" class="uk-width-small" uk-img></span>
            	<!-- <span class="uk-hidden@m"><img src="{{asset('img/logo.png')}}" class="" width="50" uk-img></span> -->
            	<span class="uk-text-lead uk-visible@m">STOCKG</span>
            </a></li>
        </ul>
    </div>
    <div class="uk-navbar-right uk-dark">
    	<ul class="uk-navbar-nav">
    		<!-- USER ONLY -->
    		@if(Auth::user()->statut==="gerant")
    		<li>
    			<a id="command-en-cours" href="#panier-content" uk-toggle> <span uk-icon="icon:cart"><span class="uk-visible@m">Command en cours</span></span> 
    				<span id="panier" class="uk-badge"></span>
    			</a>
    		</li>
    		@endif
    		<!-- // -->
    		<li><a><span uk-icon="icon:bell"></span></a></li>
    		<li><a><span uk-icon="icon:user"></span> {{Auth::user()->username}}</a></li>
    	</ul>
    </div>
</nav>

<div class="">
	<div class="">
		<div class="" uk-grid>
			<div class="uk-width-1-4@m uk-box-shadow-small uk-position-fixed  uk-visible@m" uk-height-viewport="offset-bottom: 11" style="">
				<ul class="uk-nav-default uk-padding uk-nav-parent-icon" uk-nav>
					<li class="uk-nav-header">Navigation</li>
					<li><a href="{{url('/')}}"><span uk-icon="icon:home"></span> Dashboard</a></li>
			                @if(Auth::user()->statut!=="gerant")
			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:thumbnails"></span> Produits</a>
			            <ul class="uk-nav-sub">
			            	  <!-- RESERVER A L'AMINISTRATEUR -->
			                <li><a href="{{url('admin/add-item')}}"><span uk-icon="icon:plus"></span> Add</a></li>
			                <li><a href="{{url('admin/list-item')}}"><span uk-icon="icon:list"></span> List</a></li>
			            </ul>
			        </li>
			                @endif
			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:grid"></span> Command</a>
			            <ul class="uk-nav-sub">
			            	<!-- USERS ONLY -->
			            	@if(Auth::user()->statut==="gerant")
			                <li><a href="{{url('gerant/command/add')}}"><span uk-icon="icon:plus"></span> Add</a></li>
			                <li><a href="{{url('gerant/command/list')}}"><span uk-icon="icon:list"></span> List</a></li>
			                @endif
			                <!-- // -->
			                @if(Auth::user()->statut!=="gerant")
			                <li><a href="{{url('admin/list-command')}}"><span uk-icon="icon:list"></span> List</a></li>
			                @endif
			            </ul>
			        </li>
			        <!-- ADMIN ONLY -->
			        @if(Auth::user()->statut!=="gerant")
			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:users"></span> Gerants</a>
			            <ul class="uk-nav-sub">
			                <li><a href="{{url('/admin/list-gerant')}}"><span uk-icon="icon:list"></span> List</a></li>
			                <li><a href="{{url('/admin/add-gerant')}}"><span uk-icon="icon:plus"></span> Add</a></li>
			            </ul>
			        </li>
			        <li class="uk-parent">
			        	<a href="#"><span uk-icon="icon:history"></span> Bilan</a>
			        	<ul class="uk-nav-sub">
			        		<li><a href="{{url('admin/bilan')}}"><span uk-icon="icon:minus"></span> Voir le bilan</a></li>
			        		<li><a href="{{url('admin/entree')}}"><span uk-icon="icon:minus"></span> Liste des entrees</a></li>
			        	</ul>
			        </li>
			        @endif
			        <!-- // -->

			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:settings"></span> Parametres</a>
			            <ul class="uk-nav-sub">
			            	<!-- USERS ONLY -->
			            	@if(Auth::user()->statut==="gerant")
			                <li><a href="{{url('gerant/profile')}}"><span uk-icon="icon:user"></span> Profile</a></li>
			                @endif
			                @if(Auth::user()->statut!=="gerant")
			                <li><a href="{{url('admin/profile')}}"><span uk-icon="icon:user"></span> Profile</a></li>
			                @endif
			                {!!Form::open(['url'=>'/logout'])!!}
			                <li><button type="submit" class="uk-button uk-button-link" href="{{url('logout')}}"><span uk-icon="icon:sign-out"></span> Logout</button></li>
			                {!!Form::close()!!}
			            </ul>
			        </li>
			        
			    </ul>
			</div>
			<div class="uk-width-3-4@m uk-position-right">
				<div class="uk-margin-xlarge-top uk-margin-medium-bottom" uk-scrollspy="cls:uk-animation-scale-up">@yield('content')</div>
			</div>
		</div>
	</div>	
</div>

<footer class="uk-background-primary uk-position-fixed uk-position-bottom">
	<div class="uk-container uk-light">
		<p class="uk-align-right uk-text-small">Copyright&copy;{{date('Y')}} | STOCKG  made by Smartech | v.1.0</p>
	</div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- UIkit JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/js/uikit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/js/uikit-icons.min.js"></script>
<script type="text/javascript" src="{{asset('js/myscript.js')}}"></script>
<script type="text/javascript">
	$adminPage.showImage = function () {
		 	var image = $('.item-img');

			// $('.item-img').attr('style',"background-image:url({{asset('uploads/')}})"+'/');
			for(var k=0;k<image.length;k++) {
				// console.log(image[k]);
				$(image[k]).attr('style',"background-image:url({{asset('uploads')}}"+'/'+$(image[k]).attr('id')+")");
			}
			// console.log(image);
			// console.log(image.length);
		};
		// $adminPage.getPanier("{{csrf_token()}}","{{url()->current()}}/"+"get-panier");
</script>
@yield('script')
</body>
</html>