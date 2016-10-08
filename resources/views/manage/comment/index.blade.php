@extends('layouts.manage')

@section('title', trans('manage.man_comments'))

@section('page_title', trans('manage.man_comments'))

@section('options')
<li class="{{isActive('comment.index', 1)}}"><a href="{{route('comment.index', ['status' => 1])}}">{{trans('manage.all')}}</a></li>
<li class="{{isActive('comment.index', 0)}}"><a href="{{route('comment.index', ['status' => 0])}}">{{trans('manage.trash')}}</a></li>
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
                <th width="30"><input type="checkbox" class="check_all"/></th>
                <th>ID {!! link_order('id') !!}</th>
                <th>{{trans('manage.content')}} {!! link_order('content') !!}</th>
                <th>{{trans('manage.author')}} {!! link_order('author_name') !!}</th>
                <th>{{trans('manage.author_id')}} {!! link_order('author_id') !!}</th>
                <th>{{trans('manage.posts')}} {!! link_order('post_id') !!}</th>
                <th>{{trans('manage.parent')}}</th>
                <th>{{trans('manage.status')}} {!! link_order('status') !!}</th>
                <th>{{trans('manage.created_at')}} {!! link_order('created_at') !!}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="check_items[]" class="check_item" value="{{ $item->id }}" /></td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->content }}</td>
                <td>{{ $item->author_name }}</td>
                <td>{{ $item->author_id }}</td>
                <td>{{ $item->getPost->title }}</td>
                <td>{{ $item->parent_id }}</td>
                <td>{{ $item->str_status() }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    @if(cando('edit_my_comment', $item->id))
                    <a href="{{route('comment.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
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

