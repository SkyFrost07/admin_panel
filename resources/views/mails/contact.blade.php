<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1 style="font-size: 20px;">{{trans('contact.title', ['name' => request()->getHost()])}}</h1>
        <h3 style="font-size: 18px;">{{trans('contact.content')}}</h3>
        <p style="padding: 10px; background: #e0e0e0;">
            {{$content}}
        </p>
        <h4 style="font-size: 15px;">{{trans('contact.sender_info')}}</h4>
        <ul style="line-height: 22px;">
            <li>{{trans('contact.name')}}: <strong>{{$name}}</strong></li>
            <li>{{trans('contact.email')}}: <strong>{{$email}}</strong></li>
            <li>{{trans('contact.phone')}}: <strong><a href="tel:{{$phone}}">{{$phone}}</a></strong></li>
        </ul>
    </body>
</html>
