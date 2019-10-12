<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/png" />
		 <!-- UIkit CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/css/uikit.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />
	<link rel="stylesheet" href="{!!asset('css/styles.css')!!}">
	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.uikit.min.css"/> -->

</head>
<body>
<div class="uk-position-relative">

<nav class="uk-navbar-container uk-box-shadow-small" uk-sticky style="background:rgba(255,255,255,1) !important ; "  uk-navbar="mode : click ;dropbar:true;dropbar-mode : push">



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
		            <li><a href="{{url('/')}}"><span uk-icon="icon:home"></span> {{__("Dashboard")}}</a></li>
			                @if(Auth::user()->statut!=="gerant")
			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:thumbnails"></span> {{__("Items")}}</a>
			            <ul class="uk-nav-sub">
			            	  <!-- RESERVER A L'AMINISTRATEUR -->
			                <li><a href="{{url('admin/add-item')}}"><span uk-icon="icon:plus"></span> {{__("Add")}}</a></li>
			                <li><a href="{{url('admin/list-item')}}"><span uk-icon="icon:list"></span>{{__("List")}}</a></li>
			            </ul>
			        </li>
			                @endif
			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:grid"></span> {{__("Command")}}</a>
			            <ul class="uk-nav-sub">
			            	<!-- USERS ONLY -->
			            	@if(Auth::user()->statut==="gerant")
			                <li><a href="{{url('gerant/command/add')}}"><span uk-icon="icon:plus"></span> {{__("Add")}}</a></li>
			                <li><a href="{{url('gerant/command/list')}}"><span uk-icon="icon:list"></span> {{__("List")}}</a></li>
			                @endif
			                <!-- // -->
			                @if(Auth::user()->statut!=="gerant")
			                <li><a href="{{url('admin/list-command')}}"><span uk-icon="icon:list"></span> {{__("List")}}</a></li>
			                @endif
			            </ul>
			        </li>
			        <!-- ADMIN ONLY -->
			        @if(Auth::user()->statut!=="gerant")
			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:users"></span> {{__("Gerants")}}</a>
			            <ul class="uk-nav-sub">
			                <li><a href="{{url('/admin/list-gerant')}}"><span uk-icon="icon:list"></span> {{__("List")}}</a></li>
			                <li><a href="{{url('/admin/add-gerant')}}"><span uk-icon="icon:plus"></span> {{__("Add")}}</a></li>
			            </ul>
			        </li>
			        <li class="uk-parent">
			        	<a href="#"><span uk-icon="icon:history"></span> Bilan</a>
			        	<ul class="uk-nav-sub">
			        		<li><a href="{{url('admin/bilan')}}"><span uk-icon="icon:minus"></span> {{__("Inventory")}}</a></li>
			        		<li><a href="{{url('admin/entree')}}"><span uk-icon="icon:minus"></span> {{__("Entry")}}</a></li>
			        	</ul>
			        </li>
			        @endif
			        <!-- // -->

			        <li class="uk-parent">
			            <a href="#"><span uk-icon="icon:settings"></span> {{__("Parametres")}}</a>
			            <ul class="uk-nav-sub">
			            	<!-- USERS ONLY -->
			            	@if(Auth::user()->statut==="gerant")
			                <li><a href="{{url('gerant/profile')}}"><span uk-icon="icon:user"></span> {{__("Profile")}}</a></li>
			                @endif
			                @if(Auth::user()->statut!=="gerant")
			                <li><a href="{{url('admin/profile')}}"><span uk-icon="icon:user"></span> {{__("Profile")}}</a></li>
			                @endif
			                {!!Form::open(['url'=>'/logout'])!!}
			                <li><button type="submit" class="uk-button uk-button-link" href="{{url('logout')}}"><span uk-icon="icon:sign-out"></span> {{__("Logout")}}</button></li>
			                {!!Form::close()!!}
			            </ul>
			        </li>
		        </ul>

	        </div>
	    </div>
<!-- // -->
    <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li><a href="{{url('/')}}">
            	<span class="uk-visible@m"><img src="{{asset('img/logo.png')}}" class="uk-padding-remove uk-margin-remove" style="width :70%" uk-img></span>
            	<span class="uk-text-meta uk-visible@m">STOCKG</span>
            </a></li>
        </ul>
    </div>
    <div class="uk-navbar-right uk-dark">
    	<ul class="uk-navbar-nav">
				<li class="uk-visible@m"><a> {{$date}} <span uk-icon="icon:calendar" class="uk-margin-small-left uk-button-primary uk-box-shadow-small uk-border-circle uk-padding-small"></span></a></li>
				@if(Auth::user()->statut == "gerant")
    		<!-- <li class="uk-visible@l"><a> {{$boutique}} <span uk-icon="icon:location" class="uk-margin-small-left uk-button-primary uk-box-shadow-small uk-border-circle uk-padding-small"></span></a></li> -->
				<li>
					<a> {{$boutique}} <span class="uk-button-primary uk-border-circle uk-padding-small uk-box-shadow-small uk-margin-small-left" uk-icon="icon:user"></span> </a>
					<div class="uk-navbar-dropdown">
						<ul class="uk-nav uk-navbar-nav">
							{!!Form::open(['url'=>'/logout'])!!}
							<li><button type="submit" class="uk-button" href="{{url('logout')}}"><span uk-icon="icon:sign-out"></span> {{__("Logout")}}</button></li>
							{!!Form::close()!!}
						</ul>
					</div>
				</li>
				@else
				<li>
					<a> {{Auth::user()->username}} <span class="uk-button-primary uk-border-circle uk-padding-small uk-box-shadow-small uk-margin-small-left" uk-icon="icon:user"></span> </a>
					<div class="uk-navbar-dropdown">
						<ul class="uk-nav uk-navbar-nav">
							{!!Form::open(['url'=>'/logout'])!!}
							<li><button type="submit" class="uk-button" href="{{url('logout')}}"><span uk-icon="icon:sign-out"></span> {{__("Logout")}}</button></li>
							{!!Form::close()!!}
						</ul>
					</div>
				</li>
				@endif
    	</ul>
    </div>
		<div class="uk-navbar-center uk-dark">

			<ul class="uk-navbar-nav">
				<!-- USER ONLY -->
				@if(Auth::user()->statut==="gerant")
				<li class="uk-visible@m"><a href="{{url('/gerant/dashboard')}}" uk-tooltip = "Dashboard"> <span uk-icon="icon:home" class="uk-margin-small-left uk-button-primary uk-box-shadow-small uk-border-circle uk-padding-small"></span></a></li>
				<li class="uk-visible@m">
					<a  uk-tooltip = "{{__('Items')}}"> <span uk-icon="icon:thumbnails" class="uk-margin-small-left uk-button-primary uk-box-shadow-small uk-border-circle uk-padding-small"></span></a>
					<div class="uk-navbar-dropdown">
						<ul class="uk-nav uk-navbar-nav">
							<li class="uk-nav-header">{{__('Items')}}</li>
							<li><a href="{{url('/gerant/command/add')}}">{{__("Add")}} <span uk-icon="plus"></span>	</a></li>
							<li><a href="{{url('/gerant/command/list')}}">{{__("List")}} <span uk-icon="user"></span>	</a></li>
						</ul>
					</div>
				</li>
				<li class="uk-visible@l"><a href="{{url('/gerant/profile')}}" uk-tooltip = "Settings"> <span uk-icon="icon:settings" class="uk-margin-small-left uk-button-primary uk-box-shadow-small uk-border-circle uk-padding-small"></span></a></li>
				<li>
					<a id="command-en-cours" href="#panier-content" uk-toggle> <span class="uk-button-primary uk-border-circle uk-padding-small uk-margin-small-left" uk-icon="icon:cart"></span>
						<span id="panier" class="uk-badge"></span>
						<!-- <span class="uk-visible@m"></span> -->
					</a>
				</li>
				@else
				<li class="uk-visible@m"><a href="{{url('/admin/dashboard')}}" uk-tooltip = "{{__('Dashboard')}}"> <span uk-icon="icon:home" class="uk-margin-small-left uk-button-primary uk-box-shadow-small uk-border-circle uk-padding-small"></span></a></li>
				<li class="uk-visible@m">
					<a uk-tooltip = "{{__('Items')}}"> <span uk-icon="icon:thumbnails" class="uk-margin-small-left uk-button-primary uk-box-shadow-small uk-border-circle uk-padding-small"></span></a>
					<div class="uk-navbar-dropdown">
						<ul class="uk-nav uk-navbar-nav">
              <li class="uk-nav-header">{{__("Items")}}</li>
							<li><a href="{{url('/admin/add-item')}}">{{__("Add")}} 	<span uk-icon="plus"></span> </a></li>
							<li><a href="{{url('/admin/list-item')}}">{{__("List")}} <span uk-icon="list"></span>	</a></li>
							<li><a href="{{url('/admin/list-command')}}">{{__("Command")}} <span uk-icon="list"></span>	</a></li>
							<li><a href="{{url('/admin/entree')}}">{{__("Entry")}} <span uk-icon="list"></span>	</a></li>
						</ul>
					</div>
				</li>
				<li class="uk-visible@m">
					<a href="{{url('')}}" uk-tooltip = "{{__('Shops')}}"> <span uk-icon="icon:users" class="uk-margin-small-left uk-button-primary uk-box-shadow-small uk-border-circle uk-padding-small"></span></a>
					<div class="uk-navbar-dropdown">
						<ul class="uk-nav uk-navbar-nav">
							<li class="uk-nav-header">{{__("Shops")}}</li>
							<li><a href="{{url('/admin/add-gerant')}}">Add 	<span uk-icon="plus"></span> </a></li>
							<li><a href="{{url('/admin/list-gerant')}}">List <span uk-icon="list"></span>	</a></li>
						</ul>
					</div>
				</li>
				<li class="uk-visible@m"><a href="{{url('/admin/bilan')}}" uk-tooltip = "{{__('Bilan')}}"> <span uk-icon="icon:future" class="uk-margin-small-left uk-button-primary uk-box-shadow-small uk-border-circle uk-padding-small"></span></a></li>
				<li class="uk-visible@m">
					<a href="{{url('/admin/profile')}}" uk-tooltip = "{{__('Settings')}}"> <span uk-icon="icon:settings" class="uk-margin-small-left uk-button-primary uk-box-shadow-small uk-border-circle uk-padding-small"></span></a>
				</li>
				@endif
				<!-- // -->
			</ul>
		</div>
</nav>
<div class="uk-navbar-dropbar"></div>
</div>

		<div class="uk-margin-top uk-margin-large-bottom">
			<div class="">
				<div>@yield('content')</div>
			</div>
</div>
<!-- loading modal -->
<div id="loading" class="uk-flex-top" uk-modal="esc-close:false ; bg-close : false;">
	<div class="uk-modal-dialog uk-modal-body uk-border-rounded uk-margin-auto-vertical">
		<div class="uk-align-center uk-text-center" uk-spinner> {{__('In progress')}} ... </div>
	</div>
</div>
<footer class="uk-background-primary uk-position-fixed uk-position-bottom uk-padding-remove">
	<div class="uk-container uk-light">
		<p class="uk-align-right uk-text-small">Copyright&copy;{{date('Y')}} | STOCKG  {{__('made by Smartech')}} | v.2.0</p>
	</div>
</footer>

@foreach(config('app.locales') as $locale)
@if($locale != session('locale') )
<a href="{{url('/language',[$locale])}}" uk-tooltip="{{$locale}}" class="uk-border-rounded uk-box-shadow-small lang"><img src="{!!asset('img/'.$locale.'.svg')!!}" class="uk-icon-image" alt="">	</a>
@endif
@endforeach
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- UIkit JS -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/js/uikit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/js/uikit-icons.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.uikit.min.js"></script> -->

<script type="text/javascript" src="{{asset('js/myscript.js')}}"></script>
<script type="text/javascript" src="{{asset('js/myscript_1.js')}}"></script>
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
