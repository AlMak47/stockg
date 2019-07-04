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

<nav class="uk-navbar-container" style="background: rgba(255,255,255,1) !important;" uk-navbar>
    <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li><a><img src="{{asset('img/logo.png')}}" class="uk-width-small" uk-img></span><span class="uk-text-lead">STOCKG</span></a></li>
        </ul>
    </div>
</nav>
    
    <div uk-slideshow="max-height:571">
    <ul class="uk-slideshow-items">
        <li class="uk-background-muted">
            <!-- <img src="{{asset('img/background.png')}}" alt="" uk-cover> -->
            <div class="uk-position-center uk-position-small">
                <!-- erroers -->
                @if($errors->has('username') || $errors->has('password') || session('_errors'))

                <div class="uk-alert uk-alert-danger">
                    <p>
                        {{$errors->first('username')}}
                    </p>
                    <p>
                        {{$errors->first('password')}}
                    </p>
                    <p>
                        {{session('_errors')}}
                    </p>
                </div>
                @endif
                <!-- // -->
                <div class="uk-card uk-card-default uk-width-large">
                    <div class="uk-card-header">
                        <h3 class="uk-heading"><span>LOGIN</span></h3>
                    </div>

                    <div class="uk-card-body">
                        <!-- // -->
                    
                    {!!Form::open(['url'=>'/login'])!!}
                        {!!Form::text('username',null,['class'=>'uk-input uk-margin-small'])!!}
                        {!!Form::password('password',['class'=>'uk-input uk-margin-small'])!!}
                        {!!Form::submit('Envoyer',['class'=>'uk-button uk-button-primary'])!!}
                    {!!Form::close()!!}

                        <!-- // -->
                    </div>

                </div>
            </div>
        </li>
    </ul>
</div>
<footer class="uk-background-primary uk-position-fixed uk-position-bottom">
    <div class="uk-container uk-light">
        <p class="uk-align-right uk-text-small">Copyright&copy;{{date('Y')}} | STOCKG  made by Smartech | v.1.0</p>
    </div>
</footer>
</body>
</html>