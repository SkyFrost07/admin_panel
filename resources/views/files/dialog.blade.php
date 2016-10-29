<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link rel="stylesheet" href="/public/css/bootstrap.min.css">
        <link rel="stylesheet" href="/public/css/font-awesome.min.css">
        <link rel="stylesheet" href="/public/css/filemanager.css">
        
        <style>
            .files-tab{margin-top: 10px;}
        </style>
        
        <script src="/public/js/jquery-3.1.0.min.js"></script>
    </head>

    <body class="file_dialog">
        
        <div id="main_dialog">
            <div class="container-fluid">
                
                <ul class="nav nav-tabs files-tab" role="tablist">
                    <li class="nav-item"><a class="active nav-link tab-upload-files" href="#upload-files-tab" role="tab" data-toggle="tab">{{trans('file.upload')}}</a></li>
                    <li class="nav-item"><a class="nav-link tab-select-files" href="#select-files-tab" role="tab" data-toggle="tab">{{trans('file.select_files')}}</a></li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="upload-files-tab">
                        {!! Form::open(['method' => 'post', 'route' => 'file.store', 'files' => true]) !!}
                        <div class="form-group">
                            <button type="button" class="btn-choose-files btn btn-default">
                                <i class="fa fa-upload"></i> {{trans('manage.choose_files')}}
                                {!! Form::file('files[]', ['id' => "files-input", 'multiple']) !!}
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div role="tabpanel" class="tab-pane" id="select-files-tab">
                        <ul class="list-inline files-list">

                        </ul>
                    </div>
                </div>
                
            </div>
        </div>

        <div id="footer_dialog">
            <span class="btn btn-default"><span class="num_selected">0</span> {{trans('file.is_selected')}}</span>
            <button type="button" class="btn btn-default btn-close-dialog"><i class="fa fa-close"></i> {{trans('file.close')}}</button>
            <button type="button" class="btn btn-primary btn-editor-submit-files"><i class="fa fa-check"></i> {{trans('file.submit_selected')}}</button>
        </div>
        
        <script src="/js/tether.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>

        <script>
            
            var _token = "{{csrf_token()}}";
            var multi_select = 0;
            var file_type = '_all';
            var el_preview = '.thumb_group';
            @if(isset($params['multiple']))
                multi_select = "{{$params['multiple']}}";
            @endif
            @if(isset($params['file_type']))
                file_type = "{{$params['file_type']}}";
            @endif
            @if(isset($params['el_preview']))
                el_preview = "{{$params['el_preview']}}";
            @endif
        
            var _all_files_url = "{{route('ajax_action')}}";
            
            var file_tabs = $('.files-tab');
            var el_files_list = $('.files-list');
            var files_selected_count = $('.num_selected');
            var files_selected = [];
            
            (function ($) {
                
                if (el_files_list.data('loaded') != true) {
                    $.ajax({
                        url: _all_files_url,
                        type: 'GET',
                        data: {
                            action: 'load_files',
                            type: file_type
                        },
                        success: function (data) {
                            el_files_list.html(data);
                            el_files_list.attr('data-loaded', true);
                        }
                    });
                }
                
                $('#files-input').change(function () {
//                    loading.addClass('show'); 
                    var formData = new FormData();
                    var files = $(this)[0].files;
                    for (var i in files) {
                        formData.append('files[]', files[i]);
                    }
                    var form = $(this).closest('form');
                    formData.append('_token', _token);
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if (data.length > 0) {
                                file_tabs.find('.tab-select-files').click();
                                for (var i in data) {
                                    var file = data[i];
                                    el_files_list.prepend('<li><a href="' + file.full_url + '" data-id="' + file.id + '"><img class="img-fluid" src="' + file.thumb_url + '" alt="' + file.name + '"></a></li>');
                                }
                            }
//                            loading.removeClass('show');
                            $('#files-input').val('');
                        },
                        error: function (err) {
                            console.log(err);
//                            loading.removeClass('show');
                        }
                    });
                });

                $('body').on('click', '.files-list li a', function (e) {
                    e.preventDefault();
                    var file_id = $(this).data('id');
                    var file_url = $(this).attr('href');
                    var file = {id: file_id, url: file_url};
                    if (multi_select == 1) {
                        var index = check_selected(file, files_selected);
                        if ($(this).hasClass('selected')) {
                            $(this).removeClass('selected');
                            if (index > -1) {
                                files_selected.splice(index, 1);
                            }
                        } else {
                            $(this).addClass('selected');
                            if (index === -1) {
                                files_selected.push(file);
                            }
                        }
                    } else {
                        if ($(this).hasClass('selected')) {
                            $(this).removeClass('selected');
                            files_selected = [];
                        } else {
                            el_files_list.find('li a').removeClass('selected');
                            $(this).addClass('selected');
                            files_selected = [file];
                        }
                    }
                    files_selected_count.text(files_selected.length);
                });
                
                var args = null;
                if (typeof top.tinymce != "undefined" && top.tinymce.activeEditor != null) {
                    args = top.tinymce.activeEditor.windowManager.getParams();
                }
                $('.btn-editor-submit-files').click(function (e) {
                    e.preventDefault();
                    if (args) {
                        var editor = args.editor;
                        for (var i in files_selected) {
                            var file = files_selected[i];
                            var img_content = '<p><img src="'+file.url+'" alt="image" style="max-width: 100%;"></p>';
                            editor.insertContent(img_content);
                        }
                        top.tinymce.activeEditor.windowManager.close();
                    } else {
                        window.parent.submitSelectFiles(files_selected, el_preview);
                        window.parent.closeFileModal();
                    }
                });

                $('.btn-close-dialog').click(function (e) {
                    e.preventDefault();
                    if (args) {
                        top.tinymce.activeEditor.windowManager.close();
                    } else {
                        window.parent.closeFileModal();
                    }
                });
                
            })(jQuery);
            
            function check_selected(file, files) {
                for (var i in files) {
                    if (files[i].id === file.id) {
                        return i;
                    }
                }
                return -1;
            }
        </script>

    </body>
</html>
