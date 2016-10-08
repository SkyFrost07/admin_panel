@extends('layouts.frontend')

@section('title', $media->title)

@section('content')

<h1>{{$media->title}}</h1>

<div>
    <div class="entry_content">
        {!! $media->content !!}
        {!! $media->getImage('full') !!}
    </div>
</div>

<div>
    <h3>Albums</h3>
    @if($media->albums)
    <ul>
        @foreach($media->albums as $album)
        <li><a href="{{route('album.view', ['id' => $album->id, 'slug' => $album->slug])}}">{{$album->name}}</a></li>
        @endforeach
    </ul>
    @endif
</div>

@stop

