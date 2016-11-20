@extends('layouts.manage')

@section('title', trans('manage.man_caps'))

@section('page_title', trans('manage.edit'))

@section('content')

<div class="row">
    <div class="col-sm-6">
        
        {!! show_messes() !!}
        
        @if($item)
        {!! Form::open(['method' => 'put', 'route' => ['cap.update', $item->name]]) !!}
        
        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('name', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('name') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.description')}}</label>
            {!! Form::text('label', $item->label, ['class' => 'form-control', 'placeholder' => trans('manage.description')]) !!}
            {!! error_field('label') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.higher')}}</label>
            {!! Form::select('higher', $highers, $item->higher, ['class' => 'form-control']) !!}
        </div>
        
        <a href="{{route('cap.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>
        
        {!! Form::close() !!}
        @else
        <p class="alert alert-danger">{{trans('manage.no_item')}}</p>
        @endif
    </div>
</div>

@stop

