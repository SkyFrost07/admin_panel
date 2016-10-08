@extends('layouts.manage')

@section('title', trans('manage.man_menus'))

@section('page_title', trans('manage.create'))

@section('content')

<div class="row">
    <div class="col-sm-6">

        {!! show_messes() !!}

        {!! Form::open(['method' => 'post', 'route' => 'menu.store']) !!}

        @include('manage.parts.lang_tabs')

        <div class="tab-content">
            @foreach($langs as $lang)
            <?php $code = $lang->code; ?>
            <div class="tab-pane {{ localActive($code) }}" id="tab-{{$lang->code}}">

                <div class="form-group">
                    <label>{{trans('manage.title')}}</label>
                    {!! Form::text($code.'[title]', old($code.'.title'), ['class' => 'form-control', 'placeholder' => trans('manage.title')]) !!}
                    {!! error_field($code.'.title') !!}
                </div>

            </div>
            @endforeach
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.group')}}</label>
            <select name="group_id" class="form-control">
                <option value="0">{{trans('manage.selection')}}</option>
                @if($groups)
                @foreach($groups as $group) 
                <option value="{{$group->id}}">{{$group->pivot->name}}</option>
                @endforeach
                @endif
            </select>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.parent')}}</label>
            <select name="parent_id" class="form-control">
                <option value="0">{{trans('manage.selection')}}</option>
                @if($parents)
                @foreach($parents as $parent)
                <option value="{{$parent->id}}">{{$parent->pivot->name}}</option>
                @endforeach
                @endif
            </select>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.type')}}</label>
            {!! Form::select('menu_type', list_menu_types(), old('menu_type'), ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.object')}}</label>
            {!! Form::number('type_id', old('type_id'), ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.icon')}}</label>
            {!! Form::text('icon', old('icon'), ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.open_type')}}</label>
            {!! Form::select('open_type', ['' => 'Current tab', '_blank' => 'New tab'], old('open_type'), ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.order')}}</label>
            {!! Form::number('order', old('order'), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Disable'], old('status'), ['class' => 'form-control']) !!}
        </div>

        <a href="{{route('menu.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.create')}}</button>

        {!! Form::close() !!}
    </div>
</div>

@stop

