@extends('layouts.frontend')

@section('title', trans('front.page_lists'))

@section('content')

<h1>{{trans('front.page_lists')}}</h1>

<div>
    @if($pages)
    <ul>
    @foreach($pages as $page)
    <li><a href="{{route('page.view', ['id' => $page->id, 'slug' => $page->slug])}}">{{$page->title}}</a></li>
    @endforeach
    </ul>
    @endif
</div>
<br />

@stop

