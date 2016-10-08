@extends('layouts.frontend')

@section('title', trans('front.post_lists'))

@section('content')

<h1>{{trans('front.post_lists')}}</h1>

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

