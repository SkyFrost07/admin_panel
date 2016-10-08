@extends('layouts.auth')

@section('title', trans('auth.forget_password'))

@section('content')
<div class="row">
    <div class="col-sm-6 offset-sm-3">
        <h1 class="page-header">{{trans('auth.forget_password')}}</h1>
        
        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'post_forget_pass']) !!}
        
        <div class="form-group">
            <label>{{ trans('auth.enter_email') }}</label>
            <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="example@example.com">
            {!! error_field('email') !!}
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-default">{{trans('auth.submit')}}</button>
        </div>
        
        {!! Form::close() !!}
    </div>
</div>
@stop
