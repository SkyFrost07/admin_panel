@extends('layouts.manage')

@section('title', trans('manage.man_files'))

@section('page_title', trans('manage.man_files'))

@section('options')
<li class="{{isActive('file.index')}}"><a href="{{route('file.index')}}">{{trans('manage.all')}}</a></li>
@stop

@section('actions')
@if(cando('publish_files'))
<a href="{{route('file.create')}}" class="btn btn-sm btn-success navbar-btn"><i class="fa fa-plus"></i> {{trans('manage.create')}}</a>
@endif

@if(cando('remove_other_files'))
{!! Form::open(['method' => 'post', 'route' => 'file.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.remove')]) !!}
{!! Form::hidden('action', 'remove') !!}
<button type="submit" class="btn btn-sm btn-danger navbar-btn"><i class="fa fa-remove"></i> {{trans('manage.remove')}}</button>
{!! Form::close() !!}
@endif
@stop

@section('table_nav')
@include('manage.parts.table_nav')
@stop

@section('content')

{!! show_messes() !!}
@if(!$items->isEmpty())
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th width="30"><input type="checkbox" name="massdel" class="checkall"/></th>
                <th>ID {!! link_order('id') !!}</th>
                <th width="80">{{trans('manage.thumbnail')}}</th>
                <th>{{trans('manage.name')}} {!! link_order('name') !!}</th>
                <th>{{trans('manage.url')}}</th>
                <th>{{trans('manage.type')}}</th>
                <th>{{trans('manage.mimetype')}}</th>
                <th>{{trans('manage.author')}} {!! link_order('author_id') !!}</th>
                <th>{{trans('manage.created_at')}} {!! link_order('created_at') !!}</th>
                <th width="93">{{trans('manage.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="checked[]" class="checkitem" value="{{ $item->id }}" /></td>
                <td>{{ $item->id }}</td>
                <td>{!! $item->getImage('thumbnail') !!}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->rand_dir }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->mimetype }}</td>
                <td>{{ $item->author->name }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    @if(cando('edit_my_file', $item->author_id))
                    <a href="{{route('file.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
                    @endif
                    @if(cando('remove_my_file', $item->author_id))
                    {!! Form::open(['method' => 'delete', 'route' => ['file.destroy', $item->id], 'class' => 'form-inline remove-btn', 'title' => trans('manage.remove')]) !!}
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    {!! Form::close() !!}
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

