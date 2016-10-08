@extends('layouts.frontend')

@if($page)

@section('title', $page->title)

@section('content_row')

<div class="wrapper">
    <div class="wrap_inner">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h2 class="single-title nice_clbd"><span>{{$page->title}}</span></h2>
                
                @include('front.parts.contact_form')
                
                <br />
                <strong>Hoặc gọi ngay cho chúng tôi để đặt lịch: <a href="tel:{{Option::get('i_phone')}}">{{Option::get('i_phone')}}</a></strong>
            </div>
        </div>
    </div>
</div>

@stop

@endif
