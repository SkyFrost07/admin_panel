@extends('layouts.manage')

@section('title', trans('manage.man_files'))

@section('page_title', trans('manage.create'))

@section('content')

<div class="row">
    <div class="col-sm-6">
        
        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'file.store', 'files' => true]) !!}
        
        <div class="form-group">
            <label>{{trans('manage.choose_files')}}</label>
            {!! Form::file('files[]', ['class' => '', 'multiple']) !!}
            {!! error_field('file') !!}
        </div>
        
        <a href="{{route('file.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.create')}}</button>
        
        {!! Form::close() !!}
    </div>
</div>

@stop

