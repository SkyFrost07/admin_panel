<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Manage')</title>

        <link rel="stylesheet" href="/admin_src/css/select2.min.css">
        <link rel="stylesheet" href="/admin_src/css/nested_menu.css">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/filemanager.css">
        <link rel="stylesheet" href="/admin_src/css/main.css">
        <link rel="stylesheet" href="/admin_src/css/screen.css">

        <script src="/js/jquery-3.1.0.min.js"></script>
        <script>
            var _token = '<?php echo csrf_token(); ?>';
            var _ajax_url = '<?php echo route('mn.ajax_url') ?>';
        </script>
        @yield('head')
    </head>
    <body @yield('bodyAttrs', '')>
           <header id="header">
            <nav class="navbar navbar-light bg-faded navbar-fixed-top" id="topnav">
                <a class="navbar-brand" href="{{route('dashboard')}}">Panel</a>
                <button class="navbar-toggler pull-left hidden-md-up" type="button" data-toggle="collapse" data-target="#menu_bar">
                    <i class="fa fa-bars"></i>
                </button>
                <button id="menu_toggle" class="navbar-toggler pull-left hidden-sm-down" type="button">
                    <i class="fa fa-outdent"></i>
                </button>
                <button class="navbar-toggler pull-right hidden-md-up" type="button" data-toggle="collapse" data-target="#bsmenu" aria-expanded="false">
                    <i class="fa fa-gear"></i>
                </button>
                <div class="collapse navbar-toggleable-sm" id="bsmenu">
                    <ul class="nav navbar-nav pull-md-right">
<!--                        <li class="nav-item dropdown notify-item">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <span class="num">7</span></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#"><i class="fa fa-map-marker"></i> Some notify</a></li>
                            </ul>
                        </li>-->
                        <li class="nav-item dropdown account-item">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-user"></i> {{auth()->user()->name}}</a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{route('mn.profile')}}"><i class="fa fa-info"></i> {{trans('auth.account_info')}}</a></li>
                                <li><a href="{{route('logout')}}"><i class="fa fa-power-off"></i> {{trans('auth.logout')}}</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <section id="main_body" class="{{(Session::get('is_toggle') == 1 ? 'toggle' : '')}}">

            <div id="sidebar_col">
                @include('manage.parts.menubar')
            </div>

            <div id="content_col">

                <div class="wrapper">
                    <h2 class="page-header">@yield('page_title', 'Manage')</h2>
                </div>

                <div class="wrapper content_box">
                    @yield('table_nav')

                    @yield('content')
                </div>

                <footer id="footer">
                    <div class="text-xs-center">Designed by Pinla</div>
                </footer>
            </div>

        </section>

        <div class="loading"><span></span></div>
        
        <script>
            var loading = $('.loading');
            var file_dialog_url = "{{route('file.dialog', ['multiple' => 1])}}";
            filemanager_title = '<?php echo trans('file.modal_title'); ?>';
        </script>
        <script src="/js/tether.min.js"></script>
        <script src="/admin_src/js/select2.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/admin_src/js/main.js"></script>

        @yield('foot')
    </body>
</html>
