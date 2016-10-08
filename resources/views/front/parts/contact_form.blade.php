{!! show_messes() !!}

{!! Form::open(['method' => 'post', 'route' => 'contact.send']) !!}
<div class="form-group">
    <label>{{trans('contact.name')}} (*)</label>
    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('contact.name')]) !!}
    {!! error_field('name') !!}
</div>

<div class="form-group">
    <label>{{trans('contact.email')}} (*)</label>
    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('contact.email')]) !!}
    {!! error_field('email') !!}
</div>

<div class="form-group">
    <label>{{trans('contact.phone')}} (*)</label>
    {!! Form::number('phone', old('phone'), ['class' => 'form-control', 'placeholder' => trans('contact.phone')]) !!}
    {!! error_field('phone') !!}
</div>

<div class="form-group">
    <label>{{trans('contact.content')}}</label>
    <textarea name="content" class="form-control" placeholder="{{trans('contact.content')}}">{{old('content')}}</textarea>
    {!! error_field('content') !!}
</div>

<button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> {{trans('contact.send')}}</button>
{!! Form::close() !!}

