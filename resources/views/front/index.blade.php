@extends('layouts.frontend')

@section('keyword', 'keyword')
@section('description', 'description')

@section('title', Option::get('_site_title'))

@section('head')
<link rel="stylesheet" href="/public/plugins/bxslider/jquery.bxslider.css">
@stop

@section('slider')

@if(!$slides->isEmpty())
<div class="box slider_box mgb-20">
    <ul class="list-unstyled">
        @foreach($slides as $slide)
        <li><a href="{{$slide->target}}" target="_blank"><img class="img-fluid" src="{{getImageSrc($slide->thumb_url, 'large')}}"></a></li>
        @endforeach
    </ul>
</div>
@endif

@stop

@section('content')

<div class="wrap albums_box">
    <div class="container">
        <h2 class="page-header nice_clbd"><span>{{trans('front.albums')}}</span></h2>
        <div class="wrap_inner">
            @if(!$albums->isEmpty())
            <div class="row items grid_items">
                @foreach($albums as $al)
                <div class="col-xs-6 col-md-3 item">
                    <div class="inner">
                        <div class="thumb">
                            <a href="{{route('album.view', ['id' => $al->id, 'slug' => $al->slug])}}">
                                {!! $al->getImage('medium') !!}
                            </a>
                        </div>
                        <div class="item_body">
                            <h3 class="title"><a href="{{route('album.view', ['id' => $al->id, 'slug' => $al->slug])}}">{{$al->name}}</a></h3>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>



<div class="container">
    
    @if($home_cat)
    <div class="wrapper blog_box">
        <h2 class="page-header bd_title"><span>{{$home_cat->name}}</span></h2>
        <div class="wrap_inner">
            @if(!$posts->isEmpty())
            <div class="row items">
                <div class="col-sm-6">
                    @foreach($posts as $key => $post)
                    @if($key == 0)
                    <div class="item inner first_item">
                        <div class="thumb">
                            <a href="{{route('post.view', ['id' => $post->id, 'slug' => $post->slug])}}">
                                {!! $post->getImage('large') !!}
                            </a>
                        </div>
                        <div class="item_body">
                            <h3 class="title"><a href="{{route('post.view', ['id' => $post->id, 'slug' => $post->slug])}}">{{$post->title}}</a></h3>
                            <p class="meta_desc">
                                <span class="date"><i class="fa fa-clock-o"></i> {{$post->created_at->format('d/m/y')}} </span>
                            </p>
                            <div class="excerpt">
                                {!! trim_words($post->content, 25, '...') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 media_items">
                    @else
                    <div class="item">
                        <div class="inner media">
                            <div class="pull-left media-left thumb">
                                <a href="{{route('post.view', ['id' => $post->id, 'slug' => $post->slug])}}">{!! $post->getImage('thumbnail') !!}</a>
                            </div>
                            <div class="media-body item_body">
                                <h3 class="title"><a href="{{route('post.view', ['id' => $post->id, 'slug' => $post->slug])}}">{{$post->title}}</a></h3>
                                <p class="meta_desc">
                                    <span class="date"><i class="fa fa-clock-o"></i> {{$post->created_at->format('d/m/y')}} </span>
                                </p>
                                <div class="item_desc">
                                    <div class="excerpt">{!! trim_words($post->content, 25, '...') !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

</div>

@stop

@section('foot')

<script src="/public/plugins/bxslider/jquery.bxslider.min.js"></script>
<script>
    (function($){
        $('.slider_box ul').bxSlider();
    })(jQuery);
</script>

@stop



