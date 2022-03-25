let lastScrollTop = 0;
$(window).scroll(function(event){
    let st = $(this).scrollTop();
    if (st > lastScrollTop){
        // код для прокрутки вниз
        $('.ruta-header').removeClass('active');
    } else {
        // код для прокрутки вверх
        $('.ruta-header').addClass('active');
    }
    lastScrollTop = st;
});