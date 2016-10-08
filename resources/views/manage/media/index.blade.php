@extends('layouts.manage')

@section('title', trans('manage.man_medias'))

@section('page_title', trans('manage.man_medias'))

@section('options')
<li class="{{isActive('media.index', 1)}}"><a href="{{route('media.index', ['status' => 1])}}">{{trans('manage.all')}}</a></li>
<li class="{{isActive('media.index', 0)}}"><a href="{{route('media.index', ['status' => 0])}}">{{trans('manage.trash')}}</a></li>
@stop

@section('table_nav')
@include('manage.parts.table_nav', ['action_btns' => ['destroy', 'restore', 'remove']])
@stop

@section('content')

{!! show_messes() !!}

@if(!$items->isEmpty()) 
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th width="30"><input type="checkbox" name="massdel" class="check_all"/></th>
                <th>ID {!! link_order('images.id') !!}</th>
                <th>{{trans('manage.thumbnail')}}</th>
                <th>{{trans('manage.name')}} {!! link_order('id.name') !!}</th>
                <th>{{trans('manage.slug')}}</th>
                <th>{{trans('manage.author')}} {!! link_order('author_id') !!}</th>
                <th>{{trans('manage.status')}} {!! link_order('status') !!}</th>
                <th>{{trans('manage.views')}} {!! link_order('views') !!}</th>
                <th>{{trans('manage.created_at')}} {!! link_order('created_at') !!}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="check_items[]" class="check_item" value="{{ $item->id }}" /></td>
                <td>{{$item->id}}</td>
                <td><img width="50" src="{{getImageSrc($item->thumb_url, 'thumbnail')}}"></td>
                <td>{{$item->name}}</td>
                <td>{{$item->slug}}</td>
                <td>{{$item->author ? $item->author->name : 'N/A'}}</td>
                <td>{{$item->str_status()}}</td>
                <td>{{$item->views}}</td>
                <td>{{$item->created_at}}</td>
                <td>
                    @if(cando('edit_my_post', $item->author_id))
                    <a href="{{route('media.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop

