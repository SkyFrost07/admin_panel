<?php 
$request = request(); 
$route_name = explode('.', $request->route()->getName())[0].'.';
$action_btns = isset($action_btns) ? $action_btns : [];
$status = $request->has('status') ? $request->get('status') : 1;
?>
<div class="table_nav">
    <div class="pull-left">
        <ul class="nav-status">
            @yield('options')
        </ul>
        
        <div class="btn_actions">
            <a href="{{route($route_name.'create')}}" class="create-btn btn btn-sm btn-success m-b-1" data-toggle="tooltip" title="{{trans('manage.create')}}" data-placement="top">
                <i class="fa fa-plus"></i> <span class="">{{trans('manage.create')}}</span>
            </a>

            @if(in_array('destroy', $action_btns) && $status == 1)
            <a href="{{route($route_name.'m_action')}}" action="delete" class="m_action_btn trash-btn btn btn-sm btn-warning m-b-1" data-toggle="tooltip" title="{{trans('manage.delete')}}" data-placement="top">
                <i class="fa fa-trash"></i> <span class="">{{trans('manage.delete')}}</span>
            </a>
            @endif
            
            @if(in_array('restore', $action_btns) && $status != 1)
            <a href="{{route($route_name.'m_action')}}" action="restore" class="m_action_btn restore-btn btn btn-sm btn-primary m-b-1" data-toggle="tooltip" title="{{trans('manage.restore')}}" data-placement="top">
                <i class="fa fa-mail-reply"></i> <span class="">{{trans('manage.restore')}}</span>
            </a>
            @endif
            @if(in_array('remove', $action_btns) && ($status != 1 || isset($one_status)))
            <a href="{{route($route_name.'m_action')}}" action="remove" class="m_action_btn remove-btn btn btn-sm btn-danger m-b-1" data-toggle="tooltip" title="{{trans('manage.remove')}}" data-placement="top">
                <i class="fa fa-close"></i> <span class="">{{trans('manage.remove')}}</span>
            </a>
            @endif
        </div>
    </div>
    <div class="pull-right m-b-1">
        @include('manage.parts.table_search_form')
    </div>
    <div class="clearfix"></div>
</div>

