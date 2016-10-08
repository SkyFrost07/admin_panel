@extends('layouts.manage')

@section('title', trans('manage.man_langs'))

@section('page_title', trans('manage.man_langs'))

@section('options')
<li class="{{isActive('lang.index', 1)}}"><a href="{{route('lang.index', ['status' => 1])}}">{{trans('manage.all')}}</a></li>
<li class="{{isActive('lang.index', -1)}}"><a href="{{route('lang.index', ['status' => -1])}}">{{trans('manage.disable')}}</a></li>
@stop

@section('table_nav')
@include('manage.parts.table_nav', ['action_btns' => ['create', 'destroy']])
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
                <th>{{trans('manage.icon')}}</th>
                <th>{{trans('manage.name')}} {!! link_order('name') !!}</th>
                <th>{{trans('manage.code')}} {!! link_order('code') !!}</th>
                <th>{{trans('manage.order')}} {!! link_order('order') !!}</th>
                <th>{{trans('manage.status')}} {!! link_order('status') !!}</th>
                <th>{{trans('manage.default')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="checked[]" class="checkitem" value="{{ $item->id }}" /></td>
                <td>{{ $item->id }}</td>
                <td>{!! $item->icon() !!}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->order }}</td>
                <td>{{ $item->status() }}</td>
                <td>{{ $item->str_default() }}</td>
                <td>
                    <a href="{{route('lang.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
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

