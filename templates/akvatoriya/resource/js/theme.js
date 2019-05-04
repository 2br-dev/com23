//Инициализируем работу data-href у ссылок
$.initDataHref = function() {
    $('a[data-href]:not(.addToCart):not(.applyCoupon)').on('click', function() {
        if ($.detectMedia('mobile') || !$(this).hasClass('inDialog')) {
            location.href = $(this).data('href');
        }
    });
};

$(function() {  
    // Прокрутка вверх страницы  
   $('#up').click(function () { 
        $('body, html').animate({ scrollTop: 0 });  
        return false; 
    });

   //Решение для корректного отображения масштаба в Iphone, Ipad
    if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
        var viewportmeta = document.querySelector('meta[name="viewport"]');
        if (viewportmeta) {
            viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0';
            document.body.addEventListener('gesturestart', function () {
                viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
            }, false);
        }
    }//----
    
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

//Инициализация слайдера Воды на главной странице
$(document).ready(function(){
	//$('#sliderVoda').tinycarousel();
    $('#sliderVoda').slick({
      dots: true,
      infinite: true,
      speed: 1000,
      slidesToShow: 4,
      slidesToScroll: 4,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true,
            arrows: true
          }
        },
        {
          breakpoint: 720,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
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

});

// Маска для ввода номера телефона
$(function(){
    $('input[name="phone"]').mask("+7 (999) 999-9999");
    $('input[name="user_phone"]').mask("+7 (999) 999-9999");
    $('input[name="reg_phone"]').mask("+7 (999) 999-9999");
});

$(document).ready(function(){

    

    //Инициализация плавного скролинга
    $('a[href^="#"], a[href^="."]').click( function(){ // если в href начинается с # или ., то ловим клик
	    var scroll_el = $(this).attr('href'); // возьмем содержимое атрибута href
        if ($(scroll_el).length != 0) { // проверим существование элемента чтобы избежать ошибки
	    $('html, body').animate({ scrollTop: $(scroll_el).offset().top }, 500); // анимируем скроолинг к элементу scroll_el
        }
	    return false; // выключаем стандартное действие
    });  

    
    	//var cleave = new Cleave('input[name="phone"]', {
		//    phone: true,
		//    phoneRegionCode: 'ru'
		//});  
    
    

    // Карты для магазинов Мир Воды в Краснодаре
    if ($('#map').length > 0){        
        var map, placemark_1, placemark_2, placemark_3, placemark_4, placemark_5, placemark_6, placemark_7, placemark_current, placemark_temp;
        ymaps.ready(map_init);
    }

    function map_init(){

        var animate = true;
        show_shop = function(coordinates, zoom){
            if (animate) {
                animate = false;
                map.geoObjects.remove(placemark_1);
                map.geoObjects.remove(placemark_2);
                map.geoObjects.remove(placemark_3);
                map.geoObjects.remove(placemark_4);
                map.geoObjects.remove(placemark_5);
                map.geoObjects.remove(placemark_6);
                map.geoObjects.remove(placemark_7);               
                setTimeout(function() {
                    map.setCenter(coordinates, zoom, { duration: 500, checkZoomRange: true });                    
                    animate=true;
                }, 200);
                $('.show__currentShop').removeClass('show_buttonOnMap').addClass('hide_buttonOnMap');
                $('.show__allShops').removeClass('hide_buttonOnMap').addClass('show_buttonOnMap');
            }            
        },

        show_allShops= function(){
            if (animate) {
                animate = false;
                map.geoObjects.add(placemark_1);
                map.geoObjects.add(placemark_2);
                map.geoObjects.add(placemark_3);
                map.geoObjects.add(placemark_4);
                map.geoObjects.add(placemark_5);
                map.geoObjects.add(placemark_6);
                map.geoObjects.add(placemark_7);                              
                setTimeout(function() {
                    map.setCenter([45.046816, 38.93598731787105], 12, { duration: 500, checkZoomRange: true });                    
                    animate=true;
                }, 200);
                $('.show__currentShop').removeClass('hide_buttonOnMap').addClass('show_buttonOnMap');
                $('.show__allShops').removeClass('show_buttonOnMap').addClass('hide_buttonOnMap');
            }      
        },

        map_point_current = {
            iconLayout: 'default#image',
            iconImageHref: '/templates/akvatoriya/resource/img/mirvodi/map-point.png',
            iconImageSize: [100, 100],
            iconImageOffset: [-50, -100]
        },

        map_point = {
            iconLayout: 'default#image',
            iconImageHref: '/templates/akvatoriya/resource/img/mirvodi/map-point.png',
            iconImageSize: [50, 50],
            iconImageOffset: [-25, -50]
        }    

        map = new ymaps.Map("map", {
            center: [45.046816, 38.93598731787105],
            zoom: 12, 
            controls: []
        });            
        
        placemark_1 = new ymaps.Placemark([45.071322, 38.987161], {
            hintContent: 'Роствское шоссе, 14',
            balloonContent: "Мир Воды - Ростовское шоссе, 14"
        }, map_point);

        placemark_2 = new ymaps.Placemark([45.037770, 38.961371], {
            hintContent: 'Буденного, 73',
            balloonContent: "Мир Воды - Буденного, 73"
        }, map_point);

        placemark_3 = new ymaps.Placemark([45.013084, 38.929328], {
            hintContent: 'Тургеневское шоссе, 27',
            balloonContent: "Мир Воды - Тургеневское шоссе, 27"
        }, map_point);

        placemark_4 = new ymaps.Placemark([45.041432, 38.928565], {
            hintContent: 'Алма-Атинская, 151',
            balloonContent: "Мир Воды - Алма-Атинская, 151"
        }, map_point);

        placemark_5 = new ymaps.Placemark([45.036986, 39.084728], {
            hintContent: 'Уральская, 144',
            balloonContent: "Мир Воды - Уральская, 144"
        }, map_point);

        placemark_6 = new ymaps.Placemark([45.063209, 38.919752], {
            hintContent: 'Красных Партизан, 123',
            balloonContent: "Мир Воды - Красных Партизан, 123"
        }, map_point);

        placemark_7 = new ymaps.Placemark([45.047979, 38.784502], {
            hintContent: 'ст. Елизаветинская, ул. Советская 33',
            balloonContent: "Мир Воды - ул. Советская 33"
        }, map_point);

        map.geoObjects.add(placemark_1); // Ростовское шоссе, 14 - data-shop = 1
        map.geoObjects.add(placemark_2); // Буденного, 73 - data-shop = 4
        map.geoObjects.add(placemark_3); // Тургеневское шоссе, 27 - data-shop = 5
        map.geoObjects.add(placemark_4); // Алма-Атинская, 151 data-shop = 6
        map.geoObjects.add(placemark_5); // Уральская, 144 - data-shop = 3
        map.geoObjects.add(placemark_6); // Красных Партизан, 123 - data-shop = 2
        map.geoObjects.add(placemark_7); // ст. Елизаветинская, ул. Советская, 33 - data-shop = 7

        // Ростовское шоссе, 14
        if (window.location.href == "http://com23.ru/magaziny-mir-vody/rosstovskoe-shosse-14/"){
            map.geoObjects.remove(placemark_1);
            placemark_current = new ymaps.Placemark([45.071322, 38.987161], {
                hintContent: 'Роствское шоссе, 14',
                balloonContent: "Мир Воды - Ростовское шоссе, 14"
            }, map_point_current);
            map.geoObjects.add(placemark_current);
        }

        // Красных Партизан, 123 - data-shop = 2
        if (window.location.href == "http://com23.ru/magaziny-mir-vody/krasnyh-partizan-123/"){
            map.geoObjects.remove(placemark_6);
            placemark_current = new ymaps.Placemark([45.063209, 38.919752], {
                hintContent: 'Красных Партизан, 123',
                balloonContent: "Мир Воды - Красных Партизан, 123"
            }, map_point_current);
            map.geoObjects.add(placemark_current);
        }

        // Уральская, 144 - data-shop = 3
        if (window.location.href == "http://com23.ru/magaziny-mir-vody/uralskaya-144/"){
            map.geoObjects.remove(placemark_5);
            placemark_current = new ymaps.Placemark([45.036986, 39.084728], {
                hintContent: 'Уральская, 144',
                balloonContent: "Мир Воды - Уральская, 144"
            }, map_point_current);
            map.geoObjects.add(placemark_current);
        }

        // Буденного, 73 - data-shop = 4
        if (window.location.href == "http://com23.ru/magaziny-mir-vody/budennogo-73/"){
            map.geoObjects.remove(placemark_2);
            placemark_current = new ymaps.Placemark([45.037770, 38.961371], {
                hintContent: 'Буденного, 73',
                balloonContent: "Мир Воды - Буденного, 73"
            }, map_point_current);
            map.geoObjects.add(placemark_current);
        }

        // Тургеневское шоссе, 27 - data-shop = 5
        if (window.location.href == "http://com23.ru/magaziny-mir-vody/turgenevskoe-shosse-27/"){
            map.geoObjects.remove(placemark_3);
            placemark_current = new ymaps.Placemark([45.013084, 38.929328], {
                hintContent: 'Тургеневское шоссе, 27',
                balloonContent: "Мир Воды - Тургеневское шоссе, 27"
            }, map_point_current);
            map.geoObjects.add(placemark_current);
        }

        // Алма-Атинская, 151 data-shop = 6
        if (window.location.href == "http://com23.ru/magaziny-mir-vody/almaatinskaya-151/"){
            map.geoObjects.remove(placemark_4);
            placemark_current = new ymaps.Placemark([45.041432, 38.928565], {
                hintContent: 'Алма-Атинская, 151',
                balloonContent: "Мир Воды - Алма-Атинская, 151"
            }, map_point_current);
            map.geoObjects.add(placemark_current);
        }

        // ст. Елизаветинская, ул. Советская, 33 - data-shop = 7
        if (window.location.href == "http://com23.ru/magaziny-mir-vody/sovetskaya-33/"){
            map.geoObjects.remove(placemark_7);
            placemark_current = new ymaps.Placemark([45.047979, 38.784502], {
                hintContent: 'ст. Елизаветинская, ул. Советская 33',
                balloonContent: "Мир Воды - ул. Советская 33"
            }, map_point_current);
            map.geoObjects.add(placemark_current);
        }

        /*Показать конкретный магазин на карте*/
        $('.show__currentShop').on('click', function(){
            var shop = $(this).data('shop');

            // Ростовское шоссе, 14 - data-shop = 1
            if (shop == 1){              
                show_shop([45.071313, 38.987190], 17);
            }

            // Красных Партизан, 123 - data-shop = 2
            if (shop == 2){                               
                show_shop([45.063209, 38.919752], 17);
            }

            if (shop == 3){                              
                show_shop([45.036986, 39.084728], 17);
            }

            if (shop == 4){                               
                show_shop([45.037770, 38.961371], 17);
            }

            if (shop == 5){                               
                show_shop([45.013084, 38.929328], 17);
            }

            if (shop == 6){                              
                show_shop([45.041432, 38.928565], 17);
            }

            if (shop == 7){                                
                show_shop([45.047979, 38.784502], 17);
            }      
            
        });

        $('.show__allShops').on('click', function(){
            var shop = $(this).data('shop');

            // Ростовское шоссе, 14 - data-shop = 1
            if (shop == 1){              
                show_allShops();
                map.geoObjects.remove(placemark_1);
            }

            // Красных Партизан, 123 - data-shop = 2
            if (shop == 2){                               
                show_allShops();
                map.geoObjects.remove(placemark_6);;
            }

            if (shop == 3){                              
                show_allShops();
                map.geoObjects.remove(placemark_5);
            }

            if (shop == 4){                               
                show_allShops();
                map.geoObjects.remove(placemark_2);
            }

            if (shop == 5){                               
                show_allShops();
                map.geoObjects.remove(placemark_3);
            }

            if (shop == 6){                              
                show_allShops();
                map.geoObjects.remove(placemark_4);
            }

            if (shop == 7){                                
                show_allShops();
                map.geoObjects.remove(placemark_7);
            }      
            
        });
    }

    // Карты для магазинов Мир Воды в Анапе
    if ($('#map_anapa').length > 0){
        var map_anapa, placemark_anapa1;
        ymaps.ready(map_anapa_init);
    }

    function map_anapa_init(){        

        map_point_current = {
            iconLayout: 'default#image',
            iconImageHref: '/templates/akvatoriya/resource/img/mirvodi/map-point.png',
            iconImageSize: [100, 100],
            iconImageOffset: [-50, -100]
        },

        map_anapa = new ymaps.Map("map_anapa",{
            center: [44.881867, 37.322368],
            zoom: 18,
            controls: []
        });

        placemark_anapa1 = new ymaps.Placemark([44.881867, 37.322368], {
            hintContent: "Мир Воды - Анапа, Лермонтова, 115",
            balloonContent: "Мир Воды - Анапа, Лермонтова, 115"
        }, map_point_current);

        map_anapa.geoObjects.add(placemark_anapa1);
    }

    // обработка голосования на главной странице
    /*
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
    });*/
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
}); */
        