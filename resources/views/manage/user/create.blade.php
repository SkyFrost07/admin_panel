@extends('layouts.manage')

@section('title', trans('manage.man_users'))

@section('page_title', trans('manage.create'))

@section('content')

<div class="row">
    <div class="col-sm-6">
        
        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'user.store']) !!}
        
        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('name') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.email')}} (*)</label>
            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('manage.email')]) !!}
            {!! error_field('email') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.password')}} (*)</label>
            {!! Form::password('password', ['class' => 'form-control']) !!}
            {!! error_field('password') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.repassword')}} (*)</label>
            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.role')}}</label>
            {!! Form::select('role_id', $roles, old('role_id'), ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Disabled', -1=>'Banned'], old('status'), ['class' => 'form-control']) !!}
        </div>
        
        <a href="{{route('user.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.create')}}</button>
        
        {!! Form::close() !!}
    </div>
</div>

@stop

