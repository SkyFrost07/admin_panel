@extends('layouts.manage')

@section('title', trans('manage.man_comments'))

@section('page_title', trans('manage.edit'))

@section('content')

<div class="row">
    <div class="col-sm-6">
        
        {!! show_messes() !!}
        
        @if($item)
        {!! Form::open(['method' => 'put', 'route' => ['comment.update', $item->id]]) !!}
        
        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'comment.store']) !!}
        
        <div class="form-group">
            <label>{{trans('manage.posts')}} (*)</label>
            {!! Form::text('post_id', $item->post_id, ['class' => 'form-control', 'placeholder' => trans('manage.posts')]) !!}
            {!! error_field('post_id') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.author')}}</label>
            {!! Form::text('author_id', $item->author_id, ['class' => 'form-control', 'placeholder' => trans('manage.author')]) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.content')}} (*)</label>
            {!! Form::textarea('content', $item->content, ['class' => 'form-control', 'rows' => 5, 'placeholder' => trans('manage.content')]) !!}
            {!! error_field('content') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.parent')}}</label>
            <select name="parent_id" class="form-control">
                <option value="">{{trans('manage.selection')}}</option>
                @if($parents)
                @foreach($parents as $cm)
                <option value="{{$cm->id}}" @if($cm->id == $item->parent_id) selected @endif>{{$cm->id}}</option>
                @endforeach
                @endif
            </select>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => trans('manage.active'), 0 => trans('manage.disable')], $item->status, ['class' => 'form-control']) !!}
        </div>
        
        <a href="{{route('comment.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>
        
        {!! Form::close() !!}
        @else
        <p class="alert alert-danger">{{trans('manage.no_item')}}</p>
        @endif
    </div>
</div>

@stop

