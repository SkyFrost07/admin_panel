@extends('layouts.frontend')

@section('title', trans('front.albums'))

@section('content')

<div class="wrapper albums_box">
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

@stop


