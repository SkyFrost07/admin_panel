@extends('layouts.manage')

@section('title', trans('manage.man_caps'))

@section('page_title', trans('manage.create'))

@section('content')

<div class="row">
    <div class="col-sm-6">
        
        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'cap.store']) !!}
        
        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('name') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.description')}}</label>
            {!! Form::text('label', old('label'), ['class' => 'form-control', 'placeholder' => trans('manage.description')]) !!}
            {!! error_field('label') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.higher')}}</label>
            {!! Form::select('higher', $highers, null, ['class' => 'form-control']) !!}
            {!! error_field('higher') !!}
        </div>
        
        <a href="{{route('cap.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.create')}}</button>
        
        {!! Form::close() !!}
    </div>
</div>

@stop

