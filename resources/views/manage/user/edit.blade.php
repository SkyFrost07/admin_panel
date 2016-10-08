@extends('layouts.manage')

@section('title', trans('manage.man_users'))

@section('page_title', trans('manage.edit'))

@section('content')

<div class="row">
    <div class="col-sm-6">
        
        {!! show_messes() !!}
        
        @if($item)
        {!! Form::open(['method' => 'put', 'route' => ['user.update', $item->id]]) !!}
        
        <div class="form-group">
            <label>{{trans('manage.name')}}</label>
            {!! Form::text('name', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('name') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.email')}} (*)</label>
            {!! Form::email('email', $item->email, ['class' => 'form-control', 'placeholder' => trans('manage.email')]) !!}
            {!! error_field('email') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.password')}}</label>
            {!! Form::password('password', ['class' => 'form-control']) !!}
            {!! error_field('password') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.role')}}</label>
            {!! Form::select('role_id', $roles, $item->role_id, ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [-1 => 'Disabled', 0=>'Banned', 1 => 'Active'], $item->status, ['class' => 'form-control']) !!}
        </div>
        
        <a href="{{route('user.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>
        
        {!! Form::close() !!}
        @else
        <p class="alert alert-danger">{{trans('manage.no_item')}}</p>
        @endif
    </div>
</div>

@stop

