@extends('layouts.manage')

@section('title', trans('manage.man_cats'))

@section('page_title', trans('manage.edit'))

@section('content')

<div class="row">
    <div class="col-sm-6">

        {!! show_messes() !!}
        
        @if($item)
        
        {!! Form::open(['method' => 'put', 'route' => ['cat.update', $item->id]]) !!}

        @include('manage.parts.lang_edit_tabs', ['route' => 'cat.edit'])

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('locale[name]', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('locale.name') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.slug')}}</label>
            {!! Form::text('locale[slug]', $item->slug, ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.description')}}</label>
            {!! Form::textarea('locale[description]', $item->description, ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.description')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.meta_keyword')}}</label>
            {!! Form::text('locale[meta_keyword]', $item->meta_keyword, ['class' => 'form-control', 'placeholder' => trans('manage.meta_keyword')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.meta_desc')}}</label>
            {!! Form::textarea('locale[meta_desc]', $item->meta_desc, ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.meta_desc')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.parent')}}</label>
            <select name="parent_id" class="form-control">
                <option value="0">{{trans('manage.selection')}}</option>
                {!! nested_option($parents, $item->parent_id, 0, 0) !!}
            </select>
        </div>

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Disable'], $item->status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.order')}}</label>
            {!! Form::number('order', $item->order, ['class' => 'form-control']) !!}
        </div>
        
        <input type="hidden" name="lang" value="{{$lang}}">
        {!! error_field('lang') !!}

        <a href="{{route('cat.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>

        {!! Form::close() !!}
        
        @else
        <p>{{trans('manage.no_item')}}</p>
        @endif
        
    </div>
</div>

@stop

