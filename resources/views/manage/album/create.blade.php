@extends('layouts.manage')

@section('title', trans('manage.man_albums'))

@section('page_title', trans('manage.create'))

@section('content')

{!! show_messes() !!}

{!! Form::open(['method' => 'post', 'route' => 'album.store']) !!}

<div class="row">
    <div class="col-sm-8">

        @include('manage.parts.lang_tabs')

        <div class="tab-content">
            @foreach($langs as $lang)
            <?php $code = $lang->code; ?>
            <div class="tab-pane fade in {{ locale_active($code) }}" id="tab-{{$lang->code}}">

                <div class="form-group">
                    <label>{{trans('manage.name')}} (*)</label>
                    {!! Form::text($code.'[name]', old($code.'.name'), ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
                    {!! error_field($code.'.name') !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.slug')}}</label>
                    {!! Form::text($code.'[slug]', old($code.'.slug'), ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.description')}}</label>
                    {!! Form::textarea($code.'[description]', old($code.'.description'), ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.description')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.meta_keyword')}}</label>
                    {!! Form::text($code.'[meta_keyword]', old($code.'.meta_keyword'), ['class' => 'form-control', 'placeholder' => trans('manage.meta_keyword')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.meta_desc')}}</label>
                    {!! Form::textarea($code.'[meta_desc]', old($code.'.meta_desc'), ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.meta_desc')]) !!}
                </div>

            </div>
            @endforeach
        </div>

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
            {!! Form::select('status', [1 => 'Active', 0 => 'Disable'], old('status'), ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <a href="{{route('album.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
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

