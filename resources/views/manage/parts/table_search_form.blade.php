<?php $request = request(); ?>
<form class="form-inline pull-xs-right" method="get" action="{{$request->url()}}">
    <div class="input-group input-group-sm">
        <input class="form-control form-control-sm" type="text" name="key" value="{{$request->get('key')}}" placeholder="{{trans('manage.search')}}">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-sm btn-outline-info"><i class="fa fa-search"></i></button>
        </span>
    </div>
</form>

