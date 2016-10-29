@extends('layouts.manage')

@section('title', trans('manage.man_medias'))

@section('page_title', trans('manage.create'))

@section('bodyAttrs', 'ng-app="ngFile" ng-controller="FileCtrl"')

@section('content')

{!! show_messes() !!}

{!! Form::open(['method' => 'media', 'route' => 'media.store']) !!}

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

                <div class="form-group">
                    <label>{{trans('manage.slug')}}</label>
                    {!! Form::text($code.'[slug]', old($code.'.slug'), ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.description')}}</label>
                    {!! Form::textarea($code.'[description]', old($code.'.description'), ['class' => 'form-control editor_content', 'rows' => 15, 'placeholder' => trans('manage.content')]) !!}
                </div>

            </div>
            @endforeach
        </div>
        
        @if(cando('edit_other_posts'))
        <div class="form-group">
            <label>{{trans('manage.created_at')}}</label>
            <div class="time_group">
                <div class="t_field">
                    <span>{{trans('manage.day')}}</span>
                    <select name="time[day]">
                        {!! range_options(1, 31, date('d')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.month')}}</span>
                    <select name="time[month]">
                        {!! range_options(1, 12, date('m')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.year')}}</span>
                    <select name="time[year]">
                        {!! range_options(2010, 2030, date('Y')) !!}
                    </select>
                </div>
            </div>
        </div>
        @endif

    </div>

    <div class="col-sm-4">
        
        <div class="form-group thumb_box" >
            <label>{{trans('manage.thumbnail')}}</label>
            <div class="thumb_group">
            </div>
            {!! error_field('file_ids') !!}
            <div><button type="button" class="btn btn-default btn-files-modal" data-href="{{route('file.dialog')}}">{{trans('manage.add_image')}}</button></div>
        </div>

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Trash'], old('status'), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.albums')}}</label>
            <ul class="cat-check-lists">
                @if($albums)
                @foreach($albums as $al)
                <li><label>{!! Form::checkbox('cat_ids[]', $al->id) !!} {{$al->name}}</label></li>
                @endforeach
                @endif
            </ul>
        </div>
        
        <div class="form-group">
            <a href="{{route('media.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
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

