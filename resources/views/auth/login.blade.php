@extends('layouts.auth')

@section('title', trans('auth.login'))

@section('content')
<div class="row">
    <div class="col-sm-6 offset-sm-3">
        <h1 class="page-header">{{trans('auth.login')}}</h1>
        
        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'post_login']) !!}
        
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
            <label><input type="checkbox" name="remember"> {{trans('auth.remember')}}</label>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-default">{{trans('auth.login')}}</button>
        </div>
        
        <div class="form-group">
            <a href="{{route('login_facebook')}}" class="btn btn-block btn-primary">{{trans('auth.login_with_facebook')}}</a>
        </div>
        
        <div>
            <p class="pull-left">{{trans('auth.no_account')}} <a href="{{route('get_register')}}">{{trans('auth.register')}}</a></p>
            <p class="pull-right"><a href="{{route('get_forget_pass')}}">{{trans('auth.forget_password')}}</a></p>
        </div>
        <div class="clearfix"></div>
        
        {!! Form::close() !!}
    </div>
</div>
@stop
