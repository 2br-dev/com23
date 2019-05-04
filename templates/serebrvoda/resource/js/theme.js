$(function() {    
   $('#up').click(function () { 
        $('body, html').animate({ scrollTop: 0 });  
        return false; 
    });
    
    //Инициализируем корзину
    $.cart({
        saveScroll: '.scrollBox',
        cartItemRemove: '.cartTable .iconRemove',
        cartTotalPrice: '.floatCartPrice',
        cartTotalItems: '.floatCartAmount'
    }); 
    
    $('.inDialog').openInDialog();
    $('.tabs').activeTabs();

    //Инициализируем быстрый поиск по товарам
    $(window).resize(function() {
        $( ".query.autocomplete" ).autocomplete( "close" );
    });
    
    $( ".query.autocomplete" ).each(function() {
        $(this).autocomplete({
            source: $(this).data('sourceUrl'),
            appendTo: '#queryBox',
            minLength: 3,
            select: function( event, ui ) {
                location.href=ui.item.url;
                return false;
            },
            messages: {
                noResults: '',
                results: function() {}
            }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            ul.addClass('searchItems');
            var img = $('<img />').attr('src', item.image).css('visibility', 'hidden').load(function() {
                $(this).css('visibility', 'visible');
            });
            
            return $( "<li />" )
            .append($('<div class="image" />').append(img))
            .append( '<a><span class="label">' + item.label + 
                     '</span><span class="barcode">' + item.barcode + '</span><span class="price">' + item.price + '</span> </a>' )
            .appendTo( ul );
        };
    });    
    
    //Инициализируем открытие картинок во всплывающем окне
    $('a[rel="lightbox"], .lightimage').colorbox({
       rel:'lightbox',
       className: 'titleMargin',
       opacity:0.2
    });        
}); 

$(window).load(function() {
    $('.products .photoView').live('mouseover', function() {
        if (!$(this).data('gallery')) {
    
            $('.gallery [data-change-preview]', this).mouseenter(function() {
                $(this).addClass('act').siblings().removeClass('act');
                $(this).closest('.photoView').find('.middlePreview').attr('src', $(this).data('changePreview') );
                return false;
            });            

            $('.products .photoView').mouseleave(function() {
                $('.gallery [data-change-preview]:first', this).trigger('mouseenter');
            });            
            
            $('.scrollable .scrollBox', this).jcarousel({
                vertical: true
            });
            $(window).unbind('resize.jcarousel');            
            
            $('.scrollable .control', this).on({
                'inactive.jcarouselcontrol': function() {
                    $(this).addClass('disabled');
                },
                'active.jcarouselcontrol': function() {
                    $(this).removeClass('disabled');
                }
            });            

            $('.scrollable .control.up', this).jcarouselControl({
                target: '-=3'
            });
            $('.scrollable .control.down', this).jcarouselControl({
                target: '+=3'
            });
            $(this).data('gallery', true);
        }
    });
});


//Инициализируем обновляемые зоны
$(window).bind('new-content', function(e) {
    $('.inDialog', e.target).openInDialog();
});


$(document).ready(function(){
	//$('#sliderVoda').tinycarousel();
//Инициализация слайдера Воды на главной странице
    $('.sliderVoda').slick({      
      infinite: true,
      speed: 1000,
      slidesToShow: 3,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            arrows: true
          }
        },
        {
          breakpoint: 720,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
             arrows: true
          }
        },
        {
          breakpoint: 520,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            arrows: true
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });

	jQuery(".colorbox").colorbox({
		rel: true,
		transition: 'fade'
        }	
	);

// Инициализация слайдера для блока Просмотренные товары для мобильных
    $('.lastViewedMobileSlider').slick({
      dots: true,
      infinite: true,
      speed: 1000,
      slidesToShow: 7,
      slidesToScroll: 1,
      arrows: false,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 6,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            arrows: false
          }
        },
        {
          breakpoint: 650,
          settings: {
            slidesToShow: 6,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            arrows: false
          }
        },
        {
          breakpoint: 490,
          settings: {
            slidesToShow: 5,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            arrows: false
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            arrows: false
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });

    // появление категорий для мобильных
    
});

//Инициализация плавного скролинга
$(document).ready(function(){
    $('a[href^="#"], a[href^="."]').click( function(){ // если в href начинается с # или ., то ловим клик
	    var scroll_el = $(this).attr('href'); // возьмем содержимое атрибута href
        if ($(scroll_el).length != 0) { // проверим существование элемента чтобы избежать ошибки
	    $('html, body').animate({ scrollTop: $(scroll_el).offset().top }, 500); // анимируем скроолинг к элементу scroll_el
        }
	    return false; // выключаем стандартное действие
    });

    // обработка голосования на главной странице

    // проверяем куки, и если есть - то форму голосования не показываем
    var vote = $('input[name="vote_id"]').val();
    if ($.cookie("vote_" + vote + "")){
        $('#vote__form').css("display", "none");
    }

    // Клик по кнопке закрыть в окне с сообщением "Ваш голос уже был учтен ранее, спасибо!"
    $('body').on('click', '#vote__error_close', function(){
        $('#vote__error').removeClass('show_modal');
        $('#md_overlay').removeClass('show_overlay');
        $('#vote__form').css("display", "none");
    });
    
    // Клик по кнопке закрыть в окне с сообщением "Спасибо за участие, Ваше мнение очень важно для нас!"
    $('body').on('click', '#vote__ok_close', function(){
        $('#vote__ok').removeClass('show_modal');
        $('#md_overlay').removeClass('show_overlay');
        $('#vote__form').css("display", "none");
    });

    // Нажатие + - в слайдере на главной
    $('.plusButton').click(function(){          
        var idButton = $(this).data('id');
        var minOrder = $(this).data('min');
        if (minOrder != 0){
           var inc = Number($("#amount"+idButton+"").val()) + minOrder; 
        }
        else {
            var inc = Number($("#amount"+idButton+"").val()) + 1;
        }                
                
        $("#amount"+idButton+"").val(inc);      
    });
    
    $('.minusButton').click(function(){
        var idButton = $(this).data('id');
        var minOrder = $(this).data('min');
        var dec = Number($("#amount"+idButton+"").val());
        if (minOrder != 0){
            if (dec != minOrder) {
                dec = dec - minOrder;          
            }
        }
        else{
            if (dec != 1) {
                dec = dec - 1;          
            }
        }        
        
    $("#amount"+idButton+"").val(dec);
    });
});



// Запрет копирования с сайта
/*
jQuery.fn.extend({
    disableSelection : function() {
        this.each(function() {
            this.onselectstart = function() { return false; };
            this.unselectable = "on";
            jQuery(this).css('-moz-user-select', 'none');
        });
    },
    enableSelection : function() {
        this.each(function() {
            this.onselectstart = function() {};
            this.unselectable = "off";
            jQuery(this).css('-moz-user-select', 'auto');
        });
    }
});
$(document).ready(function(){
    $('body *').disableSelection();
}); 

$(document).keydown(function(e) {
    if((e.ctrlKey && e.keyCode == 67) || (e.ctrlKey && e.keyCode == 65) || (e.shiftKey && e.keyCode == 45)) {
        return false;
    }
});

$(document).mousedown(function(e) {
    if (e.which === 3) {
        return false;
    }
});

$(document).bind("contextmenu",function(e){
    return false;
});
*/
        