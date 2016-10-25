(function ($) {
    
    if ($('.nav-status').length > 0 && $('.nav-status').html().trim() == "") {
        $('.nav-status').addClass('hidden');
    }
    $('[data-toggle="tooltip"]').tooltip();

    $('#menu_toggle').click(function () {
        var main_body = $('#main_body');
        var is_toggle = 0;
        if (main_body.hasClass('toggle')) {
            main_body.removeClass('toggle');
            is_toggle = 0;
        } else {
            main_body.addClass('toggle');
            is_toggle = 1;
        }
        $.ajax({
           url: _ajax_url,
           type: 'GET',
           data: {
               action: 'toggle',
               is_toggle: is_toggle
           }
        });
    });

    $('#menu_bar .has-sub a b').click(function (e) {
        e.preventDefault();
        var sub_menu = $(this).closest('.has-sub');
        if (sub_menu.hasClass('open')) {
            sub_menu.removeClass('open');
        } else {
            sub_menu.addClass('open');
        }
    });
    $('#menu_bar .sub-menu .active').closest('.has-sub').addClass('active');
    $('#menu_bar .sub-menu .active').closest('.sub-menu').addClass('open');

    if ($('.check_all').length > 0) {
        $('.check_all').on('change', function () {
            if ($(this).is(':checked')) {
                $('.check_item').prop('checked', true);
            } else {
                $('.check_item').prop('checked', false);
            }
        });
        var item_length = $('.check_item').length;
        $('.check_item').on('change', function(){
            if($('.check_item:checked').length === item_length){
                $('.check_all').prop('checked', true);
            }else{
                $('.check_all').prop('checked', false);
            }
        });
    }
    
    $('.new_tags').select2({
        tags: true
    });
    $('.av_tags').select2();
    
    $('.lang-tabs li a').click(function(e){
        var mce_iframe = $('.mce-edit-area iframe');
        var height = mce_iframe.height();
        mce_iframe.css('height', height);
    });
    
    $('.m_action_btn').on('click', function(e){
       e.preventDefault();
       var title = $(this).attr('data-original-title');
       var href = $(this).attr('href');
       var action = $(this).attr('action');
       var ids = [];
        $('.check_item').each(function () {
            if ($(this).is(':checked')) {
                ids.push($(this).val());
            }
        });
        
       var cf = confirm(title+' ?');
       if(cf){
           $.ajax({
               url: href,
               type: 'POST',
               data: {
                   action: action,
                   item_ids: ids,
                   _token: _token
               },
               success: function(data){
                   console.log(data);
                   window.location.reload();
               },
               error: function(err){
                   console.log(err);
                   window.location.reload();
               }
           });
       }
    });
    
    $('.value').click(function (){
       $(this).addClass('hidden-xs-up');
       $(this).next('input').removeClass('hidden-xs-up');
    });
    
})(jQuery);


