<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ config("app.name") . " - Painel administrativo" . (isset($titulo) ? " - " . $titulo : "") }}</title>
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" />
        <link rel="stylesheet" href="{{ elixir('admin/all.css') }}" />
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="{{ url("admin::home") }}" class="logo">
                    <span class="logo-mini"><b>LA</b></span>
                    <span class="logo-lg">{{ config("app.name") }}</span>
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{ route("admin::perfil") }}">
                                    <span class="hidden-xs">{{ $usuario->usuario_nome }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route("admin::logout") }}">
                                    <span class="text-danger">
                                        <i class="icon ion-power"></i> Lougout
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <aside class="main-sidebar">
                <section class="sidebar">
                    @include("admin.templates.menu")
                </section>
                
            </aside>

            <div class="content-wrapper">
                @yield("conteudo")
            </div>

            <footer class="main-footer">
                <strong>Copyright &copy; {{ date("Y") }}</strong> - Desenvolvido por <strong><a href="http://giordanolima.com.br" target="_blank">giordanolima.com.br</a></strong>. Todos os direitos reservados.
            </footer>
        </div>
        @yield("js")
        <script src="{{ asset('assets/admin/js/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ elixir('admin/all.js') }}"></script>
        @yield("scripts")
    </body>
</html>
