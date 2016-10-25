(function ($) {

    var file_tabs = $('.files-tab');
    var files_selected = [];
    var el_files_list = $('.files-list');
    var files_selected_count = $('.num_selected');
    var multi_select = false;
    var el_preview_file = "undefined";
    
    if (typeof editor_multiple != "undefined") {
        multi_select = editor_multiple == 1 ? true : false; 
    }

    $('.btn-files-modal').click(function (e) {
        e.preventDefault();
        files_selected = [];
        $('#files-modal').modal('show');
        multi_select = $(this).data('multiple') == 1 ? true : false;
        el_preview_file = $($(this).data('preview'));
        var file_type = $(this).data('type') || '_all';
        el_files_list.find('li a').removeClass('selected');
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
    });
    
    $('.file-input-field').change(function () {
          var files_length = $(this)[0].files.length; 
          var txt_len = '('+files_length+ ' files ' + text_has_selected +')';
          $(this).parent().append(txt_len);
    });
    $('#files-input').change(function () {
        loading.addClass('show'); 
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
                loading.removeClass('show');
                $('#files-input').val('');
            },
            error: function (err) {
                console.log(err);
                loading.removeClass('show');
            }
        });
    });

    $('body').on('click', '.files-list li a', function (e) {
        e.preventDefault();
        var file_id = $(this).data('id');
        var file_url = $(this).attr('href');
        var file = {id: file_id, url: file_url};
        if (multi_select) {
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

    $('.btn-submit-files').click(function (e) {
        if (el_preview_file != "undefined") {
            var preview_html = '';
            for (var i in files_selected) {
                var file = files_selected[i];
                preview_html += '<p class="file_item">' +
                        '<img src="' + file.url + '" class="img-fluid" alt="" title="">' +
                        '<a class="f_close"></a>' +
                        '<input type="hidden" name="file_ids[]" value="' + file.id + '">' +
                        '</p>';
            }
            el_preview_file.html(preview_html);
        }
        $('#files-modal').modal('hide');
    });

    $('body').on('click', '.f_close', function (e) {
        e.preventDefault();
        $(this).closest('.file_item').remove();
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
