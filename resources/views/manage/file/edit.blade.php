@extends('layouts.manage')

@section('title', trans('manage.man_files'))

@section('page_title', trans('manage.edit'))

@section('content')

{!! show_messes() !!}

@if($item)
{!! Form::open(['method' => 'put', 'route' => ['file.update', $item->id]]) !!}

<div class="row">
    <div class="col-sm-6">

        <div class="form-group">
            <label>{{trans('manage.name')}}</label>
            {!! Form::text('title', $item->title, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('name') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.url')}} (*)</label>
            {!! Form::text('url', $item->url, ['class' => 'form-control', 'placeholder' => trans('manage.url')]) !!}
            {!! error_field('url') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.type')}}</label>
            {!! Form::text('type', $item->type, ['class' => 'form-control', 'placeholder' => trans('manage.type')]) !!}
            {!! error_field('type') !!}
        </div>

        @if(cando('edit_other_files'))
        <div class="form-group">
            <label>{{trans('manage.created_at')}}</label>
            <div class="time_group">
                <div class="t_field">
                    <span>{{trans('manage.day')}}</span>
                    <select name="time[day]" class="form-control">
                        {!! range_options(1, 31, $item->created_at->format('d')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.month')}}</span>
                    <select name="time[month]" class="form-control">
                        {!! range_options(1, 12, $item->created_at->format('m')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.year')}}</span>
                    <select name="time[year]" class="form-control">
                        {!! range_options(2015, 2030, $item->created_at->format('Y')) !!}
                    </select>
                </div>
            </div>
        </div>
        @endif

        @if(cando('manage_files'))
        <div class="form-group">
            <label>{{trans('manage.author')}}</label>
            {!! Form::select('author_id', $users, $item->author_id, ['class' => 'form-control']) !!}
        </div>
        @endif

        <a href="{{route('file.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>

    </div>

    <div class="col-sm-6">

        <div class="form-group">
            <label>{{trans('manage.thumbnail')}}</label>
            <div>
                {!! $item->getImage('full') !!}
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}
@else
<p class="alert alert-danger">{{trans('manage.no_item')}}</p>
@endif

@stop


