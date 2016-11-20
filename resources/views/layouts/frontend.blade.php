<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=divice-width, initial-scale=1">

        <meta name="keyword" content="@yield('keyword')">
        <meta name="description" content="@yield('description')">

        <title>@yield('title', 'Home')</title>

        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900&subset=latin,vietnamese,latin-ext' rel='stylesheet' type='text/css'>

        @yield('head')
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/screen.css">

        <script src="/js/jquery-3.1.0.min.js"></script>

    </head>
    <body>

        <header>
            @include('front.parts.header')
        </header>

        @yield('slider', '<br />')

        <section id="main_body">

            @yield('content')

        </section>

        <section id="body_detail">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 content_col">
                        @yield('content_row')
                    </div>
                    <div class="col-sm-4 sidebar_col">
                        @yield('sidebar')
                    </div>
                </div>
            </div>
        </section>

        <footer>
            @include('front.parts.footer')
        </footer>

        <script src="/js/tether.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/main.js"></script>

        @yield('foot')

    </body>
</html>

