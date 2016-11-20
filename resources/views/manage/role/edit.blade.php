@extends('layouts.manage')

@section('title', trans('manage.man_roles'))

@section('page_title', trans('manage.edit'))

@section('content')


        
        {!! show_messes() !!}
        
        @if($item)
        {!! Form::open(['method' => 'put', 'route' => ['role.update', $item->id]]) !!}
        
        <div class="form-group">
            <label>{{trans('manage.description')}}</label>
            {!! Form::text('label', $item->label, ['class' => 'form-control', 'placeholder' => trans('manage.description')]) !!}
            {!! error_field('label') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('name', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('name') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.default')}}</label>
            {!! Form::select('default', [0 => 'No', 1 => 'Yes'], $item->default, ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2">Danh sách quyền</label>
            <div class="col-sm-10">
                <div class="box-head">
                    <div class="head-bar">
                        <label><input type="checkbox" class="item-all"> Chọn tất cả</label>
                    </div>
                </div>
                <div class="role-box">
                    @if(!$caps->isEmpty())
                    <ul class="list-unstyled row">
                        <?php $user_caps = $item->caps->lists('name')->toArray(); ?>
                        @foreach($caps as $cap)
                        <li class="col-sm-4"><label><input type="checkbox" class="item-role"  name="caps[]" value="{{ $cap->name }}" <?php echo in_array($cap->name, $user_caps) ? 'checked' : ''; ?>> {{ $cap->name }}</label></li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        
        <a href="{{route('role.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>
        
        {!! Form::close() !!}
        @else
        <p class="alert alert-danger">{{trans('manage.no_item')}}</p>
        @endif


@stop

@section('foot')
<script>
    (function ($) {
        $('.item-all').click(function () {
            if ($(this).is(':checked')) {
                $('.item-role').prop('checked', true);
            } else {
                $('.item-role').prop('checked', false);
            }
        });
        $('.item-role').change(function () {
            if ($('.item-role:checked').length === $('.item-role').length) {
                $('.item-all').prop('checked', true);
            } else {
                $('.item-all').prop('checked', false);
            }
        }).change();
    })(jQuery);
</script>
@stop

