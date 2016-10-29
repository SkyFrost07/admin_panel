@extends('layouts.manage')

@section('title', trans('manage.man_pages'))

@section('page_title', trans('manage.edit'))

@section('bodyAttrs', 'ng-app="ngFile" ng-controller="FileCtrl"')

@section('content')

{!! show_messes() !!}

@if($item)

{!! Form::open(['method' => 'put', 'route' => ['page.update', $item->id]]) !!}

<div class="row">
    <div class="col-sm-9">

        @include('manage.parts.lang_edit_tabs', ['route' => 'page.edit'])

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('locale[title]', $item->title, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('locale.title') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.slug')}}</label>
            {!! Form::text('locale[slug]', $item->slug, ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.content')}}</label>
            {!! Form::textarea('locale[content]', $item->content, ['class' => 'form-control editor_content', 'rows' => 15, 'placeholder' => trans('manage.content')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.excerpt')}}</label>
            {!! Form::textarea('locale[excerpt]', $item->excerpt, ['class' => 'form-control editor_excerpt', 'rows' => 5, 'placeholder' => trans('manage.excerpt')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.meta_keyword')}}</label>
            {!! Form::text('locale[meta_keyword]', $item->meta_keyword, ['class' => 'form-control', 'placeholder' => trans('manage.meta_keyword')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.meta_desc')}}</label>
            {!! Form::textarea('locale[meta_desc]', $item->meta_desc, ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.meta_desc')]) !!}
        </div>

    </div>
    <div class="col-sm-3">

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Trash'], $item->status, ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.template')}}</label>
            {!! Form::select('template', $templates, $item->template, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.comment_status')}}</label>
            {!! Form::select('comment_status', [1 => 'Open', 0 => 'Close'], $item->comment_status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.views')}}</label>
            {!! Form::number('views', $item->views, ['class' => 'form-control']) !!}
        </div>
        
        @if(cando('edit_other_posts'))
        <div class="form-group">
            <label>{{trans('manage.created_at')}}</label>
            <div class="time_group">
                <div class="t_field">
                    <span>{{trans('manage.day')}}</span>
                    <select name="time[day]">
                        {!! range_options(1, 31, $item->created_at->format('d')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.month')}}</span>
                    <select name="time[month]">
                        {!! range_options(1, 12, $item->created_at->format('m')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.year')}}</span>
                    <select name="time[year]">
                        {!! range_options(2010, 2030, $item->created_at->format('Y')) !!}
                    </select>
                </div>
            </div>
        </div>
        @endif
        
        <div class="form-group thumb_box" >
            <label>{{trans('manage.thumbnail')}}</label>
            <div class="thumb_group">
                @if ($item->thumbnail)
                <p class="file_item">
                    {!! $item->getThumbnail('full') !!}
                    <a class="f_close"></a>
                    <input type="hidden" name="file_ids[]" value="{{$item->thumb_id}}">
                </p>
                @endif
            </div>
            <div><button type="button" class="btn btn-default btn-files-modal" data-href="{{route('file.dialog')}}">{{trans('manage.add_image')}}</button></div>
        </div>
        
        <input type="hidden" name="lang" value="{{$lang}}">
        {!! error_field('lang') !!}

        <div class="form-group">
            <a href="{{route('page.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
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

