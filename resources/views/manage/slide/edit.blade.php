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
                <div class="thumb_item">
                    <a class="img_box">
                        @if($item->thumb_url)
                        <img class="img-fluid" src="{{getImageSrc($item->thumb_url)}}" alt="Thumbnail">
                        @endif
                    </a>
                    <input type="hidden" id="file_url" name="thumb_url" value="{{getImageSrc($item->thumb_url)}}">
                    <div class="btn_box">
                        @if($item->thumb_url)
                        <button type="button" class="close btn-remove-file"><i class="fa fa-close"></i></button>
                        @endif
                    </div>
                </div>
            </div>
            {!! error_field('thumb_url') !!}
            <div><button type="button" class="btn btn-default btn-popup-files" frame-url="/plugins/filemanager/dialog.php?type=1&field_id=file_url&field_img=file_src" data-toggle="modal" data-target="#files_modal">{{trans('manage.add_image')}}</button></div>
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
            <a href="{{route('slide.index', ['status' => 1, 'slider_id' => $slider_id])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
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

<script>
    var files_url = '<?php echo route('file.index') ?>';
    var filemanager_title = '<?php echo trans('manage.man_files') ?>';
</script>

<script src="/adminsrc/js/tinymce_script.js"></script>

@include('files.modal')

@stop

