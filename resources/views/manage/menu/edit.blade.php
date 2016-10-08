@extends('layouts.manage')

@section('title', trans('manage.man_menus'))

@section('page_title', trans('manage.edit'))

@section('content')

<div class="row">
    <div class="col-sm-6">

        {!! show_messes() !!}

        @if($item)
        {!! Form::open(['method' => 'put', 'route' => ['menu.update', $item->id]]) !!}

        <?php $langs = get_langs(); ?>
        <ul class="nav nav-tabs">
            @foreach($langs as $lang)
            <li class="{{ localActive($lang->code) }}"><a href="#tab-{{$lang->code}}" data-toggle="tab">{{$lang->name}}</a></li>
            @endforeach
        </ul>
        <br />

        <div class="tab-content">
            @foreach($langs as $lang)
            <?php
            $code = $lang->code;
            $item_desc = $lang->menu_pivot($item->id);
            ?>
            <div class="tab-pane {{ localActive($code) }}" id="tab-{{$lang->code}}">

                <div class="form-group">
                    <label>{{trans('manage.name')}} (*)</label>
                    {!! Form::text($code.'[name]', ($item_desc) ? $item_desc->name : null, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
                    {!! error_field($code.'.name') !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.slug')}}</label>
                    {!! Form::text($code.'[slug]', ($item_desc) ? $item_desc->slug : null, ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.description')}}</label>
                    {!! Form::textarea($code.'[description]', ($item_desc) ? $item_desc->description : null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.description')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.meta_keyword')}}</label>
                    {!! Form::text($code.'[meta_keyword]', ($item_desc) ? $item_desc->meta_keyword : null, ['class' => 'form-control', 'placeholder' => trans('manage.meta_keyword')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.meta_desc')}}</label>
                    {!! Form::textarea($code.'[meta_desc]', ($item_desc) ? $item_desc->meta_desc : null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.meta_desc')]) !!}
                </div>

            </div>
            @endforeach
        </div>

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Disable'], $item->status, ['class' => 'form-control']) !!}
        </div>

        <a href="{{route('menu.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>

        {!! Form::close() !!}
        @else
        <p class="alert alert-danger">{{trans('manage.no_item')}}</p>
        @endif
    </div>
</div>

@stop

