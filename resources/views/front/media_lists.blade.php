@extends('layouts.frontend')

@section('title', trans('front.media_lists'))

@section('content')

<h1>{{trans('front.media_lists')}}</h1>

<div>
    @if($medias)
    <ul>
    @foreach($medias as $media)
    <li><a href="{{route('media.view', ['id' => $media->id, 'slug' => $media->slug])}}">{{$media->name}}</a></li>
    @endforeach
    </ul>
    @endif
</div>
<br />

@stop

