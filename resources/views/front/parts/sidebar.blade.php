<div class="wrapper bar_box">
    <div class="wrap_inner">
        <h3 class="bar-title nice_clbd"><span>{{trans('front.recent_posts')}}</span></h3>
        <?php 
        $recent_posts = Post::query('post', [
            'per_page' => 5,
            'orderby' => 'created_at',
            'order' => 'desc'
        ]); 
        ?>
        @if(!$recent_posts->isEmpty())
        <div class="items media_items">
            @foreach($recent_posts as $post)
            <div class="item">
                <div class="media inner">
                    <div class="media-left pull-left thumb">
                        <a href="{{route('post.view', ['id' => $post->id, 'slug' => $post->slug])}}">{!! $post->getImage('thumbnail') !!}</a>
                    </div>
                    <div class="media-body item_body">
                        <h4 class="title"><a href="{{route('post.view', ['id' => $post->id, 'slug' => $post->slug])}}">{{$post->title}}</a></h4>
                        <div class="item_desc">
                            {!! trim_words($post->content, 15, '....') !!}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<div class="wrapper bar_box">
    <h3 class="page-header bd_title"><span>{{trans('front.set_schedule')}}</span></h3>
    <div class="wrap_inner">
        @include('front.parts.contact_form')
    </div>
</div>



