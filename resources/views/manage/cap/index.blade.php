@extends('layouts.manage')

@section('title', trans('manage.man_caps'))

@section('page_title', trans('manage.man_caps'))

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
                <th>{{trans('manage.name')}} {!! link_order('name') !!}</th>
                <th>{{trans('manage.description')}}</th>
                <th>{{trans('manage.higher')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="checked[]" class="check_item" value="{{ $item->name }}" /></td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->label }}</td>
                <td>{{ $item->higher }}</td>
                <td>
                    <a href="{{route('cap.edit', ['id' => $item->name])}}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
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

