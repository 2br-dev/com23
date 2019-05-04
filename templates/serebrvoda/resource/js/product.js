/**
* Скрипт активирует необходимые функции на странице просмотра товаров
*/
$(window).load(function() {
    $('.gallery .wrap').jcarousel();
    $('.control').on({
        'inactive.jcarouselcontrol': function() {
            $(this).addClass('disabled');
        },
        'active.jcarouselcontrol': function() {
            $(this).removeClass('disabled');
        }
    });
    $('.control.prev').jcarouselControl({
        target: '-=3'
    });
    $('.control.next').jcarouselControl({
        target: '+=3'
    });
    
    $(window).resize(function() {
        $('.gallery .scrollWrap').jcarousel('scroll', 0);
    })
    
    $('.productImages .zoom').each(function() {
        $(this).zoom({
            url: $(this).data('zoom-src'),
            onZoomIn: function() {
                $(this).siblings('.winImage').css('visibility', 'hidden');
                
            },
            onZoomOut: function() {
                $(this).siblings('.winImage').css('visibility', 'visible');
            }            
        });
    });
    
    
});

$(function() {
   $('.product .main a.item').colorbox({
       rel:'bigphotos',
       className: 'titleMargin',
       opacity:0.2
   });
   
   $('.gallery .preview').click(function() {
        var n = $(this).data('n');
        $('.product .main .item').addClass('hidden');
        $('.product .main .item[data-n="'+n+'"]').removeClass('hidden');
        
        return false;
    });
    
    var photoEx = new RegExp('#photo-(\\d+)');
    var res = photoEx.exec(location.hash);
    if ( res != null ) {
        $('.gallery .preview[data-n="'+res[1]+'"]').click();
    }
    
    var photoEx = new RegExp('#(\\d+)');
    var res = photoEx.exec(location.hash);
    if ( res != null ) {
        $('select[name="offer"]').val(res[1]);
        $('select[name="offer"] [value="'+res[1]+'"]').click();
        $('input[name="offer"][value="'+res[1]+'"]').click();

        //Если используются многомерные комплектации
        var multioffer = $('input#offer_'+res[1]);
        if (multioffer.length) {
            var multioffer_values = multioffer.data('info');
            if (multioffer_values.length) {
                for(var j in multioffer_values) {
                    $('[data-prop-title="'+multioffer_values[j][0]+'"]').val(multioffer_values[j][1]).change();
                }
            }
        }        
    }
    
    $('.gotoComment').click(function() {
        $('.writeComment .title').switcher('switchOn');
    });   
});