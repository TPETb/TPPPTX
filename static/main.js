/**
 * Created by alex on 5/19/14.
 */

var scaleMethod = 'contain';
//var scaleMethod = 'cover';


$(document).on('ready', function () {
    $(window).trigger('resize');

    $('.presentation-container').addClass('swiper-wrapper').wrap('<div class="swiper-container"></div>');
    $('.swiper-container').append('<div class="pagination"></div>');
    $('.slide').wrap('<div class="swiper-slide"></div>');

    var mySwiper = new Swiper('.swiper-container', {
        pagination: '.pagination',
        paginationClickable: true
    });
});

function scaleSlidesToViewport() {
    $('.slide').each(function () {
        if (($(window).width() / $(window).height() >= $(this).width() / $(this).height() && scaleMethod == 'cover')
            || ($(window).width() / $(window).height() <= $(this).width() / $(this).height() && scaleMethod == 'contain')) {
            // Window width/height ratio > element's (window is "wider")
            var zoom = $(window).width() / $(this).width();
            $(this).css({
                zoom: zoom,
                top: ($(window).height() - $(this).height() * zoom) / 2 + 'px'
            });
        } else {
            // Window width/height ratio < element's (slide is "wider")
            var zoom = $(window).height() / $(this).height();
            $(this).css({
                zoom: zoom,
                left: ($(window).width() - $(this).width() * zoom) / 2 + 'px'
            });
        }
    });
}

$(window).resize(function () {
    scaleSlidesToViewport();
});