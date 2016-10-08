@extends('layouts.frontend')

@section('title', trans('front.albums'))

@section('content')

<h1>{{trans('front.albums')}}</h1>

<div>
    @if($albums)
    <ul>
    @foreach($albums as $album)
    <li><a href="{{route('album.view', ['id' => $album->id, 'slug' => $album->slug])}}">{{$album->name}}</a></li>
    @endforeach
    </ul>
    @endif
</div>
<br />

@stop

