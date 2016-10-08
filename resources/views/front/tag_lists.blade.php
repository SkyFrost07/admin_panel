@extends('layouts.frontend')

@section('title', trans('front.tags'))

@section('content')

<h1>{{trans('front.tags')}}</h1>

<div>
    @if($tags)
    <ul>
    @foreach($tags as $tag)
    <li><a href="{{route('tag.view', ['id' => $tag->id, 'slug' => $tag->slug])}}">{{$tag->name}}</a></li>
    @endforeach
    </ul>
    @endif
</div>
<br />

@stop

