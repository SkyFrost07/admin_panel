@extends('layouts.manage')

@section('title', trans('manage.man_roles'))

@section('page_title', trans('manage.create'))

@section('content')

<div class="row">
    <div class="col-sm-6">
        
        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'role.store']) !!}
        
        <div class="form-group">
            <label>{{trans('manage.description')}}</label>
            {!! Form::text('label', old('label'), ['class' => 'form-control', 'placeholder' => trans('manage.description')]) !!}
            {!! error_field('label') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('name') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.default')}}</label>
            {!! Form::select('default', [0 => 'No', 1 => 'Yes'], 0, ['class' => 'form-control']) !!}
        </div>
        
        <a href="{{route('role.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.create')}}</button>
        
        {!! Form::close() !!}
    </div>
</div>

@stop

