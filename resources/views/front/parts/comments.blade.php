<div class="wrapper">
    <h3 class="page-header bd_title"><span>{{trans('front.comment')}}</span></h3>
    <div class="wrap_inner">
        @if(!$comments->isEmpty())
        <ul class="comment_lists">
            @foreach($comments as $comment)
            <li class="media comment">
                <div class="media-object media-left pull-left thumb">
                    <a href="#"></a>
                </div>
                <div class="media-body comment-body">
                    <p>{{$comment->content}}</p>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
        
        @if($post->comment_status)
        
        <div class="comment_form">
            {!! validate_messes() !!}
            {!! Form::open(['method' => 'post', 'route' => 'add_comment']) !!}
            <div class="form-group">
                <textarea name="content" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group text-right">
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <button type="submit" class="btn btn-default">{{trans('front.post_comment')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
        @endif
    </div>
</div>
