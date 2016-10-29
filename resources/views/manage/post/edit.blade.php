@extends('layouts.manage')

@section('title', trans('manage.man_posts'))

@section('page_title', trans('manage.edit'))

@section('bodyAttrs', 'ng-app="ngFile" ng-controller="FileCtrl"')

@section('content')

{!! show_messes() !!}

@if($item)

{!! Form::open(['method' => 'put', 'route' => ['post.update', $item->id]]) !!}

<div class="row">
    <div class="col-sm-9">

        @include('manage.parts.lang_edit_tabs', ['route' => 'post.edit'])

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('locale[title]', $item->title, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('locale.title') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.slug')}}</label>
            {!! Form::text('locale[slug]', $item->slug, ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.content')}}</label>
            {!! Form::textarea('locale[content]', $item->content, ['class' => 'form-control editor_content', 'rows' => 15, 'placeholder' => trans('manage.content')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.excerpt')}}</label>
            {!! Form::textarea('locale[excerpt]', $item->excerpt, ['class' => 'form-control editor_excerpt', 'rows' => 5, 'placeholder' => trans('manage.excerpt')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.meta_keyword')}}</label>
            {!! Form::text('locale[meta_keyword]', $item->meta_keyword, ['class' => 'form-control', 'placeholder' => trans('manage.meta_keyword')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.meta_desc')}}</label>
            {!! Form::textarea('locale[meta_desc]', $item->meta_desc, ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.meta_desc')]) !!}
        </div>
        
        @if(cando('edit_other_posts'))
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
                        {!! range_options(2010, 2030, $item->created_at->format('Y')) !!}
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.author')}}</label>
            {!! Form::select('author_id', $users, $item->author_id, ['class' => 'form-control']) !!}
        </div>
        @endif

    </div>
    <div class="col-sm-3">

        <div class="form-group thumb_box" >
            <label>{{trans('manage.thumbnail')}}</label>
            <div class="thumb_group">
                @if ($item->thumbnail)
                <p class="file_item">
                    {!! $item->getThumbnail('full') !!}
                    <a class="f_close"></a>
                    <input type="hidden" name="file_ids[]" value="{{$item->thumb_id}}">
                </p>
                @endif
            </div>
            <div><button type="button" class="btn btn-default btn-files-modal" data-href="{{route('file.dialog', ['multiple' => false])}}">{{trans('manage.add_image')}}</button></div>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Trash'], $item->status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.categories')}}</label>
            <ul class="cat-check-lists">
                {!! cat_check_lists($cats, $curr_cats) !!}
            </ul>
        </div>

        <div class="form-group">
            <label>{{trans('manage.new_tags')}}</label>
            <select name="new_tags[]" multiple class="new_tags form-control" style="width: 97%;">
                @if(old('new_tags'))
                @foreach(old('new_tags') as $tag)
                <option selected value="{{$tag}}">{{$tag}}</option>
                @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label>{{trans('manage.available_tags')}}</label>
            <select name="tag_ids[]" multiple class="av_tags form-control" style="width: 97%;">
                <?php $curr_tags = $curr_tags ? $curr_tags : []; ?>
                @foreach($tags as $tag)
                <option value="{{$tag->id}}" {{ in_array($tag->id, $curr_tags) ? 'selected' : '' }}>{{$tag->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>{{trans('manage.comment_status')}}</label>
            {!! Form::select('status', [1 => 'Open', 0 => 'Close'], $item->comment_status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.views')}}</label>
            {!! Form::number('views', $item->views, ['class' => 'form-control']) !!}
        </div>
        
        <input type="hidden" name="lang" value="{{$lang}}">
        {!! error_field('lang') !!}

        <a href="{{route('post.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>

    </div>
</div>

{!! Form::close() !!}

@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop

@section('foot')

@include('files.manager')

<script src="/plugins/tinymce/tinymce.min.js"></script>
<script src="/admin_src/js/tinymce_script.js"></script>

@stop

