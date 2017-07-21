$(function() {
    $('.banner').unslider({
        animation: 'vertical',
        autoplay: true,
        infinite: true,
        nav: false,
        arrows: false
    })

    $('.testimonials').unslider({
        autoplay: true,
        infinite: true,
        arrows: false,
        nav: false
    })

});


function favouriteSermon() {
    var form = document.querySelector('form');
    form.submit();
}