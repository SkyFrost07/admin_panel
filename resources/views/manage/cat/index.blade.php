@extends('layouts.manage')

@section('title', trans('manage.man_cats'))

@section('page_title', trans('manage.man_cats'))

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
                <th width="30"><input type="checkbox" class="check_all"/></th>
                <th>ID {!! link_order('taxs.id') !!}</th>
                <th>{{trans('manage.name')}} {!! link_order('td.name') !!}</th>
                <th>{{trans('manage.slug')}}</th>
                <th>{{trans('manage.parent')}} {!! link_order('parent_id') !!}</th>
                <th>{{trans('manage.order')}} {!! link_order('order') !!}</th>
                <th>{{trans('manage.count')}} {!! link_order('count') !!}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            {!! $tableCats !!}
        </tbody>
    </table>
</div>
@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop

