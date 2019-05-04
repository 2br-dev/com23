/**
* Плагин, инициализирующий работу механизма выбора комплектации продукта.
* Позволяет изменять связанные цены на странице при выборе комплектации, 
* а также подменяет ссылку на добавление товара в корзину с учетом комплектации
*/
(function( $ ){
    $.fn.changeOffer = function( method ) {
        var defaults = {
            dataAttribute    : 'changeCost',
            addToCartButtons : '.addToCart',
            offerProperty    : '.offerProperty',
            notAvaliable      : 'notAvaliable',   // Класс для нет в наличии
            hiddenClass      : 'hidden',
            offerParam       : 'offer',
            context          : '[data-id]',      // Родительский элемент, ограничивающий поиск элемента с ценой
            
            //Параметры для многомерных комплектаций
            multiOffers      : false,                    // Флаг использования мн. комплектаций
            multiOffersInfo  : [],                       // Массив с информацией о комплектациях
            multiOfferName   : '[name^="multioffers["]', // Списки многомерных комплектаций
            hiddenOffersName : '[name="hidden_offers"]', // Комплектации с информацией
            theOffer         : '[name="offer"]',         // Скрытое поле откуда забирается комплектация
            
            //Паметры для складов
            sticksRow        : '.warehouseRow', //Оборачивающий контейнер с рисками значений заполнености склада
            stick            : '.stick',         //Риски со значениями заполнености склада
            stickFilledClass : 'filled'         //Класс заполненой риски
        },
        args = arguments;
        
        return this.each(function() {
            var $this = $(this), 
                data = $this.data('changeOffer');

            var methods = {
                init: function(initoptions) {
                    if (data) return;
                    data = {}; $this.data('changeOffer', data);
                    data.options = $.extend({}, defaults, initoptions);
                    $this.change(changeOffer);
                    
                    var context = $(this).closest(data.options.context);
             
                    //Многомерные комплектации
                    if ($(data.options.hiddenOffersName, context).length>0){
                        data.options.multiOffers = true;
                        
                        //Соберём информацию для работы
                        $(data.options.hiddenOffersName,context).each(function(i){
                            data.options.multiOffersInfo[i]           = {};
                            data.options.multiOffersInfo[i]['id']     = this;
                            data.options.multiOffersInfo[i]['info']   = $(this).data('info');
                            data.options.multiOffersInfo[i]['num']    = $(this).data('num');
                            data.options.multiOffersInfo[i]['sticks'] = $(this).data('sticks');
                        });

                        //Навесим событие
                        context
                             .on('change',data.options.multiOfferName,changeMultiOffer);
                    }
                }
            };
            
            //private 
            /**
            * Смена комплектации
            * 
            */
            var changeOffer = function() { 
                var $selected = $this;
                
                if ($this.get(0).tagName.toLowerCase() == 'select') {
                    $selected = $('option:selected', $this);
                }
                
                var list    = $selected.data(data.options.dataAttribute);
                var context = $selected.closest(data.options.context);
                var offer   = $selected.val();
                
                $.each(list, function(selector, cost) {
                    $(selector, context).text(cost);
                });
                
                $(data.options.offerProperty).addClass(data.options.hiddenClass);
                $(data.options.offerProperty+'[data-offer="'+offer+'"]').removeClass('hidden');
                
                $(data.options.addToCartButtons, context).each(function() {
                    var offerParam = data.options.offerParam+'='+offer;
                    $(this).attr('href', function(i, h) {
                        var regex = new RegExp("(\\&|\\?)"+data.options.offerParam+"=\\d+",'g');
                        h = h.replace(regex, '');
                        return h + (h.indexOf('?') != -1 ? "&"+offerParam : "?"+offerParam);
                    });                    
                });
                
                showAvailability(offer);
            },
            
            /**
            * Показывает наличие на складе
            * @param Array stock_arr - массив с наличием "палочек наличия" для отображения 
            */
            showStockSticks = function(stock_arr, context) {
               //Сбросим наличие
               $(data.options.sticksRow+" "+data.options.stick, context).removeClass(data.options.stickFilledClass);
               //Установим значения рисок заполнености склада
               $(data.options.sticksRow, context).each(function() {
                   var warehouse_id = $(this).data('warehouseId');
                   var num = stock_arr[warehouse_id]; //Количество рисок для складов
                   for(var j=0; j<num; j++) {
                       $(data.options.stick+":eq("+j+")", $(this)).addClass(data.options.stickFilledClass);
                   }
               });
            },
            
            /**
            * Показывает наличие товара, приписывает или убирает класс
            * notAvaliable
            * 
            */
            showAvailability = function(offerValue) {
               var context = $this.closest(data.options.context); 
                
               if (data.options.multiOffers){ //Если используются многомерные комплектации
                  var num = data.options.multiOffersInfo[offerValue]['num'];
                  //Покажем наличие на складах
                  showStockSticks(data.options.multiOffersInfo[offerValue]['sticks'], context);
               }else{ 
                  var offer = $(data.options.theOffer+"[value='"+offerValue+"']",context); //Если радиокнопками
                  if (!offer.length){ //Если выпадающее меню
                     var offer = $(data.options.theOffer+" option:selected",context);  
                  } 
                  var num = offer.data('num');
                  //Покажем наличие на складах
                  showStockSticks(offer.data('sticks'), context);
               }
               
               
               if (typeof(num) != 'undefined') {
                   if (num==0){ //Если не доступно
                      $(context).addClass(data.options.notAvaliable); 
                   }else{ //Если  доступно
                      $(context).removeClass(data.options.notAvaliable);   
                   }
               }
            }
            
            //Многомерные комплектации
            /**
            * Смена/Выбор многомерной комплектации
            * 
            */
            changeMultiOffer = function (){
                var context = $this.closest(data.options.context);
                
                var selected = []; //Массив, что выбрано
                //Соберём информацию, что изменилось
                $(data.options.multiOfferName,context).each(function(i){
                    selected[i]          = {};
                    selected[i]['title'] = $(this).data('propTitle');
                    selected[i]['value'] = $(this).val();
                });
                
                //Найдём инпут с комплектацией
                var input_info = data.options.multiOffersInfo;
                var offer      = false; //Cпрятанная комплектация, которую мы выбрали
                
                for(var j=0;j<input_info.length;j++){
                    var info = input_info[j]['info']; //Группа с информацией
                    var found = 0;                //Флаг, что найдены все совпадения
                    for(var m=0;m<info.length;m++){
                        for(var i=0;i<selected.length;i++){
                           if ((selected[i]['title']==info[m][0])&&(selected[i]['value']==info[m][1])){
                               found++;
                           } 
                        }
                        if (found==selected.length){ //Если удалось найди совпадение, то выходим
                            offer = input_info[j]['id']
                            break;
                        }
                    }
                }

                //Отметим выбранную комплектацию
                var offer_val = 0;
                if (offer){ // Если комплектация выбранная присутствует
                   offer_val = $(offer).val(); 
                   $(data.options.theOffer,context).val(offer_val);  
                }else{ // Если комплектации такой не нашлось, выберем нулевую компл.
                   $(data.options.theOffer,context).val(offer_val); 
                }
                
                $(data.options.offerProperty).addClass(data.options.hiddenClass);
                $(data.options.offerProperty+'[data-offer="'+offer_val+'"]').removeClass('hidden');
                
                //Поменяем цену за комплектацию
                var dataCost = $(offer).data('changeCost');
                for(var i in dataCost){
                    $(i,context).html(dataCost[i]);
                }
                
                //Покажем наличие товара после выбора комплектации
                showAvailability(offer_val);
            }
            
            if ( methods[method] ) {
                methods[ method ].apply( this, Array.prototype.slice.call( args, 1 ));
            } else if ( typeof method === 'object' || ! method ) {
                return methods.init.apply( this, args );
            }
        });
    }

})( jQuery );


$(function() {
    $('[name="offer"]').changeOffer();
});