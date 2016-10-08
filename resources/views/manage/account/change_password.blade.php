@extends('layouts.manage')

@section('title', trans('auth.change_pass'))

@section('page_title', trans('auth.change_pass'))

@section('content')

{!! show_messes() !!}

<div class="row">
    <div class="col-sm-8">
        {!! show_messes() !!}
            
        {!! Form::open(['method' => 'post', 'route' => 'mn.update_pass']) !!}
        <?php
        $user = auth()->user(); 
        ?>
        
        <div class="form-group row">
            <label class="col-sm-4">{{trans('auth.old_password')}}</label>
            <div class="col-sm-8">
                {!! Form::password('old_password', ['class' => 'form-control', 'placeholder' => trans('auth.old_password')]) !!}
                {!! error_field('old_password') !!}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4">{{trans('auth.new_password')}}</label>
            <div class="col-sm-8">
                {!! Form::password('new_password', ['class' => 'form-control', 'placeholder' => trans('auth.new_password')]) !!}
                {!! error_field('new_password') !!}
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-4">{{trans('auth.repassword')}}</label>
            <div class="col-sm-8">
                {!! Form::password('new_password_confirmation', ['class' => 'form-control', 'placeholder' => trans('auth.repassword')]) !!}
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-4"></label>
            <div class="col-sm-8">
                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{trans('auth.save')}}</button>
                <a href="{{route('mn.profile')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('auth.back')}}</a>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>

@stop

