<ul class="lang_tabs">
    @foreach($langs as $lang)
    <li class="{{ lang_active($lang->code) }}"><a href="{{route($route, ['id' => $item->id, 'lang' => $lang->code])}}">{{$lang->name}}</a></li>
    @endforeach
</ul>
<br />

