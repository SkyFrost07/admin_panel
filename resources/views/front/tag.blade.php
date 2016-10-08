@extends('layouts.frontend')

@section('title', $tag->name)

@section('content')

<h1>{{$tag->name}}</h1>

<div>
    @if($posts)
    <ul>
    @foreach($posts as $post)
    <li><a href="{{route('post.view', ['id' => $post->id, 'slug' => $post->slug])}}">{{$post->title}}</a></li>
    @endforeach
    </ul>
    @endif
</div>
<br />

@stop

