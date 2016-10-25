@extends('layouts.manage')

@section('title', trans('manage.man_slides'))
<?php
$page_title = ($slider) ? $slider->name. ' / '. trans('manage.man_slides') : trans('manage.man_slides');
?>
@section('page_title', $page_title)

@section('content')

{!! show_messes() !!}

<div class="table_nav">
    <div class="pull-left">
        
        <div class="btn_actions">
            <a href="{{route('slide.create', ['slider_id' => $slider_id])}}" class="create-btn btn btn-sm btn-success m-b-1" data-toggle="tooltip" title="{{trans('manage.create')}}" data-placement="top">
                <i class="fa fa-plus"></i> <span class="">{{trans('manage.create')}}</span>
            </a>

            <a href="{{route('slide.m_action', ['slider_id' => $slider_id])}}" action="remove" class="m_action_btn remove-btn btn btn-sm btn-danger m-b-1" data-toggle="tooltip" title="{{trans('manage.remove')}}" data-placement="top">
                <i class="fa fa-close"></i> <span class="">{{trans('manage.remove')}}</span>
            </a>
        </div>
    </div>
    <div class="pull-right m-b-1">
        @include('manage.parts.table_search_form')
    </div>
    <div class="clearfix"></div>
</div>

@if(!$items->isEmpty()) 
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th width="30"><input type="checkbox" name="massdel" class="check_all"/></th>
                <th>ID {!! link_order('id') !!}</th>
                <th>{{trans('manage.thumbnail')}}</th>
                <th>{{trans('manage.name')}} {!! link_order('thumb_url') !!}</th>
                <th>{{trans('manage.created_at')}} {!! link_order('created_at') !!}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="checked[]" class="check_item" value="{{ $item->id }}" /></td>
                <td>{{$item->id}}</td>
                <td><img width="50" src="{{$item->getThumbnailSrc('thumbnail')}}"></td>
                <td>{{$item->name}}</td>
                <td>{{$item->created_at}}</td>
                <td>
                    <a href="{{route('slide.edit', ['id' => $item->id, 'slider_id' => $slider_id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
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

@section('foot')

@if(request()->has('slider_id'))
<script>
    (function($){
        var create_url = $('.create-btn').attr('href');
        var slider_id = '<?php echo request()->get('slider_id'); ?>';
        $('.create-btn').attr('href', create_url+'?slider_id='+slider_id);
    })(jQuery);
</script>
@endif

@stop

