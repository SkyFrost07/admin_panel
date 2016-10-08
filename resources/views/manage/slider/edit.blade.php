@extends('layouts.manage')

@section('title', trans('manage.man_sliders'))

@section('page_title', trans('manage.edit'))

@section('content')


{!! show_messes() !!}

@if($item)

@include('manage.parts.lang_edit_tabs', ['route' => 'slider.edit'])

{!! Form::open(['method' => 'put', 'route' => ['slider.update', $item->id]]) !!}

<div class="row">
    <div class="col-sm-6">

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('locale[name]', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('locale.name') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Disable'], $item->status, ['class' => 'form-control']) !!}
        </div>

        <input type="hidden" name="lang" value="{{$lang}}">
        {!! error_field('lang') !!}

        <div class="form-group">
            <a href="{{route('slider.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>
        </div>

    </div>

</div>

{!! Form::close() !!}

@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop


