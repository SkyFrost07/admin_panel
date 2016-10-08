@extends('layouts.frontend')

@if($cat)
@section('title', $cat->name)

@section('content_row')

<div class="wrapper">
    <div class="wrap_inner">
        <h2 class="single-title nice_clbd"><span>{{$cat->name}}</span></h2>

        @if(!$posts->isEmpty())
        <div class="items row_items">
            @foreach($posts as $post)
            <div class="row item">
                <div class="col-xs-3 col-md-4 thumb">
                    <a href="{{route('post.view', ['id' => $post->id, 'slug' => $post->slug])}}">
                        {!! $post->getImage('medium') !!}
                    </a>
                </div>
                <div class="col-xs-9 col-md-8 item_body">
                    <h3 class="title"><a href="{{route('post.view', ['id' => $post->id, 'slug' => $post->slug])}}">{{$post->title}}</a></h3>
                    <p class="meta_desc">
                        <span class="date"><i class="fa fa-clock-o"></i> {{$post->created_at->format('d/m/Y')}}</span>
                    </p>
                    <div class="item_desc">
                         {!! trim_words($post->content, 20, ' ...') !!}
                    </div>
                </div>
            </div>
            @endforeach
            
            <div class="paginate text-center">
                {!! $posts->render() !!}
            </div>
        </div>
        @endif

    </div>
</div>

@stop

@section('sidebar')
<div class="wrapper bar_box">
    <h3 class="page-header bd_title"><span>{{trans('front.set_schedule')}}</span></h3>
    <div class="wrap_inner">
        @include('front.parts.contact_form')
    </div>
</div>
@stop

@else

@endif

