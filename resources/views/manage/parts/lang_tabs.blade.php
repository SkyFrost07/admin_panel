<ul class="nav nav-tabs lang-tabs">
    @foreach($langs as $lang)
    <li class="nav-item"><a class="nav-link {{ locale_active($lang->code) }}" href="#tab-{{$lang->code}}" data-toggle="tab">{{$lang->name}}</a></li>
    @endforeach
</ul>
<br />

