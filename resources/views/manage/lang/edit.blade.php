@extends('layouts.manage')

@section('title', trans('manage.man_langs'))

@section('page_title', trans('manage.edit'))

@section('content')

<div class="row">
    <div class="col-sm-6">
        
        {!! show_messes() !!}
        
        @if($item)
        {!! Form::open(['method' => 'put', 'route' => ['lang.update', $item->id]]) !!}
        
        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('name', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('name') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.code')}} (*)</label>
            {!! Form::text('code', $item->code, ['class' => 'form-control', 'placeholder' => trans('manage.code')]) !!}
            {!! error_field('code') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.icon')}} (*)</label>
            {!! Form::text('icon', $item->icon, ['class' => 'form-control', 'placeholder' => trans('manage.icon')]) !!}
            {!! error_field('icon') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.folder')}} (*)</label>
            {!! Form::text('folder', $item->folder, ['class' => 'form-control', 'placeholder' => trans('manage.folder')]) !!}
            {!! error_field('folder') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.default')}}</label>
            {!! Form::select('default', [0 => 'No', 1 => 'Yes'], $item->default, ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', -1 => 'Disable'], $item->status, ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.order')}}</label>
            {!! Form::number('order', $item->order, ['class' => 'form-control']) !!}
            {!! error_field('order') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.unit')}} (*)</label>
            {!! Form::text('unit', $item->unit, ['class' => 'form-control', 'placeholder' => 'VNĐ']) !!}
            {!! error_field('unit') !!}
        </div>
        <div class="form-group">
            <label>{{trans('manage.ratio_currency')}} (*)</label>
            {!! Form::text('ratio_currency', $item->ratio_currency, ['class' => 'form-control', 'placeholder' => trans('manage.ratio_currency')]) !!}
            {!! error_field('ratio_currency') !!}
        </div>
        
        <a href="{{route('lang.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>
        
        {!! Form::close() !!}
        @else
        <p class="alert alert-danger">{{trans('manage.no_item')}}</p>
        @endif
    </div>
</div>

@stop

