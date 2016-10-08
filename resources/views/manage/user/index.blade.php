@extends('layouts.manage')

@section('title', trans('manage.man_users'))

@section('page_title', trans('manage.man_users'))

@section('options')
<li class="{{isActive('user.index', 1)}}"><a href="{{route('user.index', ['status' => 1])}}">{{trans('manage.all')}}</a></li>
<li class="{{isActive('user.index', 0)}}"><a href="{{route('user.index', ['status' => 0])}}">{{trans('manage.ban')}}</a></li>
<li class="{{isActive('user.index', -1)}}"><a href="{{route('user.index', ['status' => -1])}}">{{trans('manage.disable')}}</a></li>
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
                <th>{{trans('manage.name')}} {!! link_order('name') !!}</th>
                <th>{{trans('manage.email')}} {!! link_order('email') !!}</th>
                <th>{{trans('manage.password')}}</th>
                <th>{{trans('manage.role')}} {!! link_order('role_id') !!}</th>
                <th>{{trans('manage.status')}} {!! link_order('status') !!}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="check_items[]" class="check_item" value="{{ $item->id }}" /></td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>*************</td>
                <td>{{ $item->role->label }}</td>
                <td>{{ $item->status() }}</td>
                <td>
                    @if(cando('edit_my_user', $item->id))
                    <a href="{{route('user.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
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

