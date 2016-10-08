@extends('layouts.auth')

@section('title', trans('auth.register'))

@section('content')
<div class="row">
    <div class="col-sm-6 offset-sm-3">
        <h1 class="page-header">{{trans('auth.register')}}</h1>
        
        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'post_register']) !!}
        
        <div class="form-group">
            <label>{{ trans('auth.name') }}</label>
            <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="{{trans('auth.name')}}">
            {!! error_field('name') !!}
        </div>
        
        <div class="form-group">
            <label>{{ trans('auth.email') }}</label>
            <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="example@example.com">
            {!! error_field('email') !!}
        </div>
        
        <div class="form-group">
            <label>{{ trans('auth.password') }}</label>
            <input type="password" name="password" class="form-control" placeholder="{{trans('auth.password')}}">
            {!! error_field('password') !!}
        </div>
        
        <div class="form-group">
            <label>{{ trans('auth.repassword') }}</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="{{trans('auth.repassword')}}">
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-default">{{trans('auth.register')}}</button>
        </div>
        
        <div><p>{{trans('auth.has_account')}} <a href="{{route('get_login')}}">{{trans('auth.login')}}</a></p></div>
        
        {!! Form::close() !!}
    </div>
</div>
@stop
