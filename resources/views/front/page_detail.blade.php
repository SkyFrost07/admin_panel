@extends('layouts.frontend')

@if($page)
@section('title', $page->title)

@section('content_row')

<div class="wrapper">
    <div class="wrap_inner">
        <h2 class="single-title nice_clbd"><span>{{$page->title}}</span></h2>
        
        <div class="entry_content">
            {!! $page->content !!}
        </div>
    </div>
</div>
@stop

@section('sidebar')
@include('front.parts.sidebar')
@stop

@else

@endif

