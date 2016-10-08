<div class="nicecl_bd"></div>
<div id="top_head">
    <div class="container">
        <div class="row">
            <div class="col-xs-7 col-md-8 text-center txt-run">
                <marquee><img src="/public/images/icon/car-icon.png" > {!! Option::get('_text_header') !!} <img src="/public/images/icon/rose-icon.png" ></marquee>
            </div>
            <div class="col-xs-5 col-md-4 text-right">
                <span class="phone_box"><a href="tel:{{Option::get('i_phone')}}"><i class="fa fa-phone"></i> {{Option::get('i_phone')}}</a></span>
                <ul class="nav_socials list-inline">
                    <li><a target="_blank" href="{{Option::get('link_facebook')}}"><img src="/public/images/icon/facebook-icon.png"></a></li>
                    <li><a target="_blank" href="{{Option::get('link_google_plus')}}"><img src="/public/images/icon/google-plus-icon.png"></a></li>
                    <li><a target="_blank" href="{{Option::get('link_youtube')}}"><img src="/public/images/icon/YouTube-icon.png"></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-default" id="top_menu">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs_menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('home')}}"><img id="logo" src="{{Option::get('_logo')}}"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs_menu">
            <ul class="nav navbar-nav navbar-right">
                {!! $nestedMenus !!}
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="nicecl_bd"></div>
