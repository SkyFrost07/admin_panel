@extends('layouts.manage')

@section('title', trans('manage.man_slides'))

@section('page_title', trans('manage.edit'))

@section('bodyAttrs', 'ng-app="ngFile" ng-controller="FileCtrl"')

@section('content')

{!! show_messes() !!}

@if($item)

{!! Form::open(['method' => 'put', 'route' => ['slide.update', $item->id]]) !!}

<div class="row">
    <div class="col-sm-8">
        
        @include('manage.parts.lang_edit_tabs', ['route' => 'slide.edit'])

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('locale[name]', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('locale.name') !!}
        </div>

        <div class="form-group thumb_box" >
            <label>{{trans('manage.thumbnail')}}</label>
            <div class="thumb_group">
                @if ($item->thumb_id)
                <p class="file_item">
                    {!! $item->getThumbnail('full') !!}
                    <a class="f_close"></a>
                    <input type="hidden" name="file_ids[]" value="{{$item->thumb_id}}">
                </p>
                @endif
            </div>
            {!! error_field('file_ids') !!}
            <div><button type="button" class="btn btn-default btn-files-modal" data-href="{{route('file.dialog')}}">{{trans('manage.add_image')}}</button></div>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.target')}}</label>
            {!! Form::text('target', $item->target, ['class' => 'form-control']) !!}
        </div>

    </div>
    <div class="col-sm-4">

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => trans('manage.enable'), 0 => trans('manage.disable')], $item->status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <input type="hidden" name="lang" value="{{$lang}}">
            <a href="{{route('slide.index', ['status' => 1, 'slider_id' => $item->slider_id])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>
        </div>

    </div>
</div>

{!! Form::close() !!}

@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop

@section('foot')

<script src="/plugins/tinymce/tinymce.min.js"></script>
<script src="/admin_src/js/tinymce_script.js"></script>

@include('files.manager')

@stop

