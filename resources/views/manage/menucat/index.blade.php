@extends('layouts.manage')

@section('title', trans('manage.man_menucats'))

@section('page_title', trans('manage.man_menucats'))

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
                <th>ID {!! link_order('taxs.id') !!}</th>
                <th>{{trans('manage.name')}} {!! link_order('td.name') !!}</th>
                <th>{{trans('manage.man_childs')}}</th>
                <th>{{trans('manage.slug')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="check_items[]" class="check_item" value="{{ $item->id }}" /></td>
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td><a href="{{route('menucat.edit', ['id' => $item->id])}}" class="btn btn-sm btn-primary"><i class="fa fa-long-arrow-right"></i></a></td>
                <td>{{$item->slug}}</td>
                <td>
                    <a href="{{route('menucat.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
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

