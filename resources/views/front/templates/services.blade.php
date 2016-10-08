@extends('layouts.frontend')

@section('title', trans('front.our_services'))

@section('content_row')

<div class="wrapper">
    <div class="wrap_inner">
        <h2 class="single-title nice_clbd"><span>{{trans('front.our_services')}}</span></h2>
        @if(!$services->isEmpty())
        <div class="items row_items">
            @foreach($services as $sv)
            <div class="row item">
                <div class="col-xs-3 col-md-4 thumb">
                    <a href="{{route('service.view', ['id' => $sv->id, 'slug' => $sv->slug])}}">
                        {!! $sv->getImage('medium') !!}
                    </a>
                </div>
                <div class="col-xs-9 col-md-8 item_body">
                    <h3 class="title"><a href="{{route('service.view', ['id' => $sv->id, 'slug' => $sv->slug])}}">{{$sv->title}}</a></h3>
                    <div class="item_desc">
                        {!! $sv->content !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@stop

@section('sidebar')
@include('front.parts.sidebar')
@stop

