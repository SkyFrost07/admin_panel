@extends('layouts.manage')

@section('title', trans('manage.man_slides'))

@section('page_title', trans('manage.create'))

@section('bodyAttrs', 'ng-app="ngFile" ng-controller="FileCtrl"')

@section('content')

{!! show_messes() !!}

{!! Form::open(['method' => 'slide', 'route' => 'slide.store']) !!}

<div class="row">
    <div class="col-sm-8">
        
        @include('manage.parts.lang_tabs')

        <div class="tab-content">
            @foreach($langs as $lang)
            <?php $code = $lang->code; ?>
            <div class="tab-pane fade in {{ locale_active($code) }}" id="tab-{{$lang->code}}">

                <div class="form-group">
                    <label>{{trans('manage.name')}} (*)</label>
                    {!! Form::text($code.'[name]', old($code.'.name'), ['class' => 'form-control', 'placeholder' => trans('manage.title')]) !!}
                    {!! error_field($code.'.name') !!}
                </div>

            </div>
            @endforeach
        </div>
        
        <div class="form-group thumb_box" >
            <label>{{trans('manage.thumbnail')}}</label>
            <div class="thumb_group">
            </div>
            {!! error_field('file_ids') !!}
            <div><button type="button" class="btn btn-default btn-files-modal" data-href="{{route('file.dialog')}}">{{trans('manage.add_image')}}</button></div>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.target')}}</label>
            {!! Form::text('target', old('target'), ['class' => 'form-control']) !!}
        </div>
        
    </div>

    <div class="col-sm-4">

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Trash'], old('status'), ['class' => 'form-control']) !!}
        </div>
        
        {!! Form::hidden('slider_id', $slider_id) !!}
        
        <div class="form-group">
            <a href="{{route('slide.index', ['status' => 1, 'slider_id' => $slider_id])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.create')}}</button>
        </div>

    </div>
</div>

{!! Form::close() !!}

@stop

@section('foot')

<script src="/plugins/tinymce/tinymce.min.js"></script>
<script src="/admin_src/js/tinymce_script.js"></script>

@include('files.manager')

@stop

