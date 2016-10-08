@extends('layouts.manage')

@section('title', trans('manage.man_albums'))

@section('page_title', trans('manage.edit'))

@section('content')


{!! show_messes() !!}

@if($item)

@include('manage.parts.lang_edit_tabs', ['route' => 'album.edit'])

{!! Form::open(['method' => 'put', 'route' => ['album.update', $item->id]]) !!}

<div class="row">
    <div class="col-sm-8">

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('locale[name]', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('locale.name') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.slug')}}</label>
            {!! Form::text('locale[slug]', $item->slug, ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.description')}}</label>
            {!! Form::textarea('locale[description]', $item->description, ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.description')]) !!}
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
    <div class="col-sm-4">

        <div class="form-group thumb_box" >
            <label>{{trans('manage.thumbnail')}}</label>
            <div class="thumb_group">
                <div class="thumb_item">
                    <a class="img_box">
                        @if($item->image_url)
                        <img class="img-fluid" src="{{getImageSrc($item->image_url)}}" alt="Thumbnail">
                        @endif
                    </a>
                    <input type="hidden" id="file_url" name="image_id" value="{{getImageSrc($item->image_url)}}">
                    <div class="btn_box">
                        @if($item->image_url)
                        <button type="button" class="close btn-remove-file"><i class="fa fa-close"></i></button>
                        @endif
                    </div>
                </div>
            </div>
            <div><button type="button" class="btn btn-default btn-popup-files" frame-url="/plugins/filemanager/dialog.php?type=1&field_id=file_url&field_img=file_src" data-toggle="modal" data-target="#files_modal">{{trans('manage.add_image')}}</button></div>
        </div>

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Disable'], $item->status, ['class' => 'form-control']) !!}
        </div>

        <input type="hidden" name="lang" value="{{$lang}}">
        {!! error_field('lang') !!}

        <div class="form-group">
            <a href="{{route('album.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
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

<script src="/admin_src/js/tinymce_script.js"></script>

@include('files.modal')

@stop

