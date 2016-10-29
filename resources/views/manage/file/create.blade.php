@extends('layouts.manage')

@section('title', trans('manage.man_files'))

@section('page_title', trans('manage.create'))

@section('content')

<div class="row">
    <div class="col-sm-6">
        
        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'file.store', 'files' => true]) !!}
        
        <div class="form-group">
            <button class="btn-choose-files btn btn-default">
                <i class="fa fa-upload"></i> {{trans('manage.choose_files')}}
                {!! Form::file('files[]', ['class' => 'file-input-field', 'multiple']) !!}
            </button>
            {!! error_field('file') !!}
            <div id="selected_files">
                
            </div>
        </div>
        
        <a href="{{route('file.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.create')}}</button>
        
        {!! Form::close() !!}

    </div>
</div>

@stop

