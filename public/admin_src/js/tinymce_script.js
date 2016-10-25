(function ($) {
    if(typeof tinymce != "undefined"){
        tinymce.init({
            selector: '.editor_content',
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager ex_loadfile"
            ],
            image_advtab: true,
            relative_urls: false,
            toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor | responsivefilemanager | ex_loadfile",
            ex_file_title: "Danh sách tệp tin",
            ex_filepath: file_dialog_url,
            external_filemanager_path: "/plugins/filemanager/",
            filemanager_title: filemanager_title,
            external_plugins: {"filemanager": "/plugins/filemanager/plugin.min.js"}
        });
    }
    
    $('.btn-popup-files').click(function(e){
        $('#files-frame').attr('src', $(this).attr('frame-url'));
    });
    
    $('body').on('click', '.btn-remove-file', function(e){
        e.preventDefault();
        $(this).closest('.thumb_item').find('.img_box').html('');
        $(this).closest('.thumb_item').find('input, textarea').val('');
        $(this).remove();
    });

})(jQuery);

function responsive_filemanager_callback(field_id){
    var field = $('#'+field_id);
    var url = field.val();
    var img_box = field.parent().find('.img_box');
    var btn_box = field.parent().find('.btn_box');
    img_box.html('<img src="'+url+'" class="img-fluid" alt="thumbnail">');
    btn_box.html('<button type="button" class="close btn-remove-file"><i class="fa fa-close"></i></button>');
}


