(function ($) {
    $('#top_menu .dropdown a').on('click', function () {
        var href = $(this).attr('href');
        window.location.href = href;
    });
    $('#top_menu .dropdown').on('mouseover', function () {
        $(this).addClass('open');
    }).on('mouseleave', function () {
        $(this).removeClass('open');
    });
})(jQuery);


