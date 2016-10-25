@extends('layouts.manage')

@section('title', trans('manage.man_files'))

@section('page_title', trans('manage.man_files'))

@section('table_nav')
@include('manage.parts.table_nav', ['action_btns' => ['remove'], 'one_status' => true])
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
                <th width="80">{{trans('manage.thumbnail')}}</th>
                <th>{{trans('manage.name')}} {!! link_order('title') !!}</th>
                <th>{{trans('manage.url')}}</th>
                <th>{{trans('manage.type')}}</th>
                <th>{{trans('manage.mimetype')}}</th>
                <th>{{trans('manage.author')}} {!! link_order('author_id') !!}</th>
                <th>{{trans('manage.created_at')}} {!! link_order('created_at') !!}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="check_items[]" class="check_item" value="{{ $item->id }}" /></td>
                <td>{{ $item->id }}</td>
                <td>{!! $item->getImage('thumbnail') !!}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->url }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->mimetype }}</td>
                <td>{{ $item->author->name }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    @if(cando('edit_my_file', $item->author_id))
                    <a href="{{route('file.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
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

