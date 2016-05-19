<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>{{ $titulo or "Login - ".config("app.name") }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" />
        <link rel="stylesheet" href="{{ elixir('admin/all.css') }}" />
        
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body class="hold-transition login-page skin-blue">
        <div class="login-box">
            <div class="login-logo">
                <img src="{{ asset("assets/admin/img/logo.png") }}" />
            </div>
            <div class="login-box-body">
                @yield('conteudo')
            </div>
        </div>
        <script src="{{ elixir('admin/login.js') }}"></script>
        <script>
            $(function () {
                $('input[type=checkbox]').iCheck({
                    checkboxClass: 'icheckbox_flat-blue'
                });
            });
        </script>
    </body>
</html>
