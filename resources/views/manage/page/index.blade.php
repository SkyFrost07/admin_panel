@extends('layouts.manage')

@section('title', trans('manage.man_pages'))

@section('page_title', trans('manage.man_pages'))

@section('options')
<li class="{{isActive('page.index', 1)}}"><a href="{{route('page.index', ['status' => 1])}}">{{trans('manage.all')}}</a></li>
<li class="{{isActive('page.index', 0)}}"><a href="{{route('page.index', ['status' => 0])}}">{{trans('manage.trash')}}</a></li>
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
                <th>ID {!! link_order('id') !!}</th>
                <th>{{trans('manage.name')}} {!! link_order('pd.title') !!}</th>
                <th>{{trans('manage.slug')}}</th>
                <th>{{trans('manage.comment_count')}} {!! link_order('comment_count') !!}</th>
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
                <td>{{$item->title}}</td>
                <td>{{$item->slug}}</td>
                <td>{{$item->comment_count}}</td>
                <td>{{$item->str_status()}}</td>
                <td>{{$item->views}}</td>
                <td>{{$item->created_at}}</td>
                <td>
                    @if(cando('edit_my_post', $item->author_id))
                    <a href="{{route('page.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="paginate">
    {!! $items->render() !!}
</div>

@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop

