@extends('layouts.frontend')

@if($album)

@section('title', $album->name)

@section('head')
<link rel="stylesheet" href="/public/plugins/fancybox/jquery.fancybox.css">
@stop

@section('content')

<div class="container">
    <div class="wrapper">
        <div class="wrap_inner">
            <h2 class="single-title nice_clbd"><span>{{$album->name}}</span></h2>

            @if($images)
            <div class="row items grid_items gallery_items">
                @foreach($images as $image)
                <div class="item col-xs-6 col-md-3">
                    <div class="inner">
                        <div class="thumb">
                            <a rel="gallery" href="{{getImageSrc($image->thumb_url, 'full')}}" title="{{$image->name}}">
                                {!! $image->getImage('medium') !!}
                            </a>
                        </div>
                        <div class="item_body">
                            <h3 class="title"><a href="{{getImageSrc($image->thumb_url, 'full')}}">{{$image->name}}</a></h3>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            
        </div>
    </div>
</div>

@stop

@section('foot')
<script src="/public/plugins/fancybox/jquery.fancybox.js"></script>
<script>
    (function($){
        $('.gallery_items .thumb a').fancybox({
            captions: true
        });
    })(jQuery);
</script>
@stop

@else

@endif

