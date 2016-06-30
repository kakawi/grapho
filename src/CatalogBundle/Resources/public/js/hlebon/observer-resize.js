$(function() {
    var mobile = 800;
    var status;
    var width = $(window).width();

    if (width <= mobile) {
        status = 'mobile';
        $(window).trigger('mobile');
    } else {
        status = 'desktop';
        $(window).trigger('desktop');
    }

    $(window).on('resize', function(e) {
        width = $(window).width();
        if (width <= mobile && status === 'desktop') {
            $(this).trigger('mobile');
            status = 'mobile';

        } else if (width > mobile && status === 'mobile') {
            $(this).trigger('desktop');
            status = 'desktop';
        }
    });
});