@extends('layouts.auth')

@section('title', trans('auth.forget_password'))

@section('content')
<div class="row">
    <div class="col-sm-6 offset-sm-3">
        <h1 class="page-header">{{trans('auth.forget_password')}}</h1>
        
        {!! show_messes() !!}
        
        @if(isset($token) && $token)
        
        {!! Form::open(['method' => 'post', 'route' => 'post_reset_pass']) !!}
        
        <div class="form-group">
            <label>{{ trans('auth.new_password') }}</label>
            <input type="password" name="password" value="{{old('password')}}" class="form-control">
            {!! error_field('password') !!}
        </div>
        <div class="form-group">
            <label>{{ trans('auth.repassword') }}</label>
            <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control">
        </div>
        
        <div class="form-group">
            <input type="hidden" name="token" value="{{$token}}">
            {!! error_field('token') !!}
            <button type="submit" class="btn btn-block btn-default">{{trans('auth.submit')}}</button>
        </div>
        
        {!! Form::close() !!}
        
        @else
        
        <p class="alert alert-danger">{{trans('error.invalid_token')}}</p>
        
        @endif
        
    </div>
</div>
@stop
