<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/png" />
  		 <!-- UIkit CSS -->
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/css/uikit.min.css" />
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />
    <title>No Permission</title>
  </head>
  <body>
    <div class="uk-section uk-section-default">
      <div class="uk-container">
        <div class="uk-alert-warning uk-padding uk-text-center uk-border-rounded uk-box-shadow-large" uk-alert>
          <h1><span uk-icon="icon : warning ; ratio : 2  "></span> Access Refuse</h1>
          <p class="uk-text-lead">Veuillez Contacter l'Administrateur</p>
          {!!Form::open(['url'=>'/logout'])!!}
          <button type="submit" class="uk-button uk-button-default"><span uk-icon="icon : sign-out"></span> Logout</button>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- UIkit JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.26/js/uikit-icons.min.js"></script>
  </body>
</html>
