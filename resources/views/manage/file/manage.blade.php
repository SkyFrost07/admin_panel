@extends('layouts.manage')

@section('title', trans('manage.man_files'))

@section('page_title', trans('manage.man_files'))

@section('content')

<div class="manage_file">
    <iframe class="file-frame" frameborder="0" src="" style="width: 100%; height: 100vh;"> </iframe>
</div>

<script>
    (function($){
        $(document).ready(function(){
           $('iframe.file-frame').attr('src', '/plugins/filemanager/dialog.php?type=1'); 
        });
    })(jQuery);
</script>

@stop

