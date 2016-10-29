@extends('layouts.manage')

@section('title', trans('manage.man_options'))

@section('head')
<style>
    .create-btn{display: none;}
</style>
@stop

@section('page_title', trans('manage.man_options'))

@section('table_nav')
@include('manage.parts.table_nav', ['action_btns' => ['remove'], 'one_status' => true])
@stop

@section('content')

{!! show_messes() !!}

<div class="row">
    
    <div class="col-sm-4" style="border-top: 1px solid #eee; padding-top: 10px;">
        <h3 class="box-title">{{trans('manage.create')}}</h3>
        {!! Form::open(['method' => 'post', 'route' => 'option.store']) !!}

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            <input type="text" name="key" class="form-control" placeholder="{{trans('manage.name')}}">
            {!! error_field('key') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.value')}} (*)</label>
            <textarea name="value" id="file_url" rows="2" class="form-control" placeholder="{{trans('manage.value')}}"></textarea>
            {!! error_field('value') !!}
            <br />
            <div class="thumb_group">
            </div>
            <div><button type="button" class="btn btn-default btn-files-modal" data-href="{{route('file.dialog')}}">{{trans('manage.add_image')}}</button></div>
        </div>

        <div class="form-group">
            <label>{{trans('manage.language')}}</label>
            <select name="lang_code" class="form-control">
                @foreach(get_langs(['fields' => ['code']]) as $lang)
                <option value="{{$lang->code}}">{{$lang->code}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button class="btn btn-info" type="submit"><i class="fa fa-plus"></i> {{trans('manage.create')}}</button>
        </div>

        {!! Form::close() !!}
    </div>

    <div class="col-sm-8">

        @if(!$items->isEmpty())
        {!! Form::open(['method' => 'post', 'route' => 'option.update_all']) !!}
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" name="massdel" class="check_all"/></th>
                        <th>{{trans('manage.name')}} {!! link_order('option_key') !!}</th>
                        <th>{{trans('manage.value')}} {!! link_order('value') !!}</th>
                        <th>{{trans('manage.language')}} {!! link_order('lang_code') !!}</th>
                        <th>{{trans('manage.actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td><input type="checkbox" name="check_items[]" class="check_item" value="{{ $item->option_key }}" /></td>
                        <td>{{ $item->option_key }}</td>
                        <td>
                            <span class="value">{{$item->value}}</span>
                            <input name="{{$item->lang_code.'['.$item->option_key.']'}}" class="form-control hidden-xs-up" value="{{ $item->value }}">
                        </td>
                        <td>{{ $item->lang_code }}</td>
                        <td>
                            <a href="{{route('option.delete', ['key' => $item->option_key])}}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="{{trans('manage.destroy')}}"><i class="fa fa-trash"></i></a>
                            <!--<a href="{{'route'}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="{{trans('manage.save')}}"><i class="fa fa-save"></i></a>-->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>
        </div>
        {!! Form::close() !!}

        @else
        <p>{{trans('manage.no_item')}}</p>
        @endif

    </div>

</div>

@stop

@section('foot')

@include('files.manager')

@stop

