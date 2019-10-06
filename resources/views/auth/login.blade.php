<!DOCTYPE html>
<html>
<head>
    <title>{{config('app.name')}}</title>
    <!-- UIkit CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/css/uikit.min.css" />

<!-- UIkit JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/js/uikit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/js/uikit-icons.min.js"></script>
</head>
<body>

<nav class="uk-navbar-container uk-box-shadow-small" style="background: rgba(255,255,255,1) !important;" uk-navbar>
    <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li><a><img src="{{asset('img/logo.png')}}" class="" uk-img></span><span class="uk-text-meta">STOCKG</span></a></li>
        </ul>
    </div>
</nav>
<div class="uk-container uk-margin-large-top">
  @if(session('_errors'))
  <div class="uk-alert-danger uk-width-large uk-align-center uk-box-shadow-small uk-border-rounded" uk-alert>
    <a href="#" class="uk-alert-close" uk-close></a>
    <p>{{session('_errors')}}</p>
  </div>
  @endif
  @if($errors->any())
  @foreach($errors->all() as $error)
  <div class="uk-alert-danger uk-width-large uk-align-center uk-box-shadow-small uk-border-rounded" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p>{{$error}}</p>
  </div>
  @endforeach
  @endif
  <div class="uk-card uk-card-small uk-border-rounded uk-width-large uk-align-center uk-card-default">
    <div class="uk-card-header">
      <h3 class="uk-card-title">Login</h3>
    </div>
    <div class="uk-card-body">
      {!!Form::open(['url'=>'/connexion', 'class'=>'uk-form' , 'id'=>'form-login'])!!}
      {!!Form::label("Username *")!!}
      {!!Form::text('username',null,['class'=>'uk-input uk-margin-small','placeholder'=>'Enter Username'])!!}
      {!!Form::label("Password *")!!}
      {!!Form::password('password',['class'=>'uk-input uk-margin-small','placeholder'=>'Enter Password'])!!}
      {!!Form::submit('Envoyer',['class'=>'uk-button uk-button-primary uk-border-rounded uk-box-shadow-small'])!!}
      {!!Form::close()!!}
    </div>
  </div>
</div>
<div id="loading" uk-modal="esc-close:false ; bg-close : false;">
	<div class="uk-modal-dialog uk-modal-body uk-border-rounded">
		<div class="uk-align-center uk-text-center" uk-spinner> In progress ... </div>
	</div>
</div>

<footer class="uk-background-primary uk-position-fixed uk-position-bottom">
    <div class="uk-container uk-light">
        <p class="uk-align-right uk-text-small">Copyright&copy;{{date('Y')}} | STOCKG  made by Smartech | v.2.0</p>
    </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function () {
  $("#form-login").on('submit',function () {
    UIkit.modal("#loading").show()
  })
})
</script>
</body>
</html>
