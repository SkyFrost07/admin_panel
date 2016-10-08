@extends('layouts.frontend')

@if($post)
@section('title', $post->title)

@section('content')

<div class="wrapper">
    <div class="wrap_inner">
        
        <h2 class="single-title nice_clbd"><span>{{$post->title}}</span></h2>

        <div class="meta">
            <span class="date"><i class="fa fa-clock-o"></i> {{$post->created_at->format('d/m/Y')}}</span>
        </div>


        <div class="entry_content">
            {!! $post->content !!}
        </div>
        
    </div>
</div>

@include('front.parts.comments')

@stop

@section('sidebar')
@include('front.parts.sidebar')
@stop

@else

@endif

