$(function(){
    
    /**
    * Навешивание подсказки корректировки адреса
    */
    function dadataBindHints()
    {
        /**
        * Определим по IP город, которые были заранее определены
        */
        if (global.dadata_ip_city && $("[name^='addr_city']").length && !$("[name^='addr_city']").val()){
            $("[name^='addr_city']").val(global.dadata_ip_city);
        }
        /**
        * Определим по IP регион, которые были заранее определены
        */
        if (global.dadata_ip_region && $("[name^='addr_region_id']").length){
            var option = $("[name^='addr_region_id'] option:contains(\""+global.dadata_ip_region+"\")");
            if (option.length){
                option.prop('selected', true);
            }else{
                var option = $("[name^='addr_region_id'] option:contains(\""+global.dadata_ip_region_text+"\")");
                if (option.length){
                   option.prop('selected', true); 
                }
            }
        }
        
        
        /**
        * Инициализируем общие функции по подсветке подсказок
        * 
        * @type Object
        */
        var init_params = {
            serviceUrl     : "//dadata.ru/api/v2",
            count          : global.dadata_config.count ? global.dadata_config.count : 5, //кол
            token          : global.dadata_config.api_key,
            partner        : "READYSCRIPT.ZAKUSILO",
            hint           : false, 
            addon          : 'none', //Не показывать в правом углу ничего лишнего
            deferRequestBy : 100, //Задержка между запросами
            minChars       : 2, //Минимальное количество символов
            //Уберём лишние пробелы
            onSelect: function(suggestion) {
                $(this).val($.trim($(this).val()));
            }
        };
        
        if (global.dadata_config.fio_show_hint){
            /**
            * Включает подсказки в Наименовании компании 
            */
            $("[name^='user_fio'], [name='name']").suggestions($.extend(init_params, {
                type           : "NAME",
                gender         : "UNKNOWN",
                /*
                * Возвращает строку для вставки в поле ввода при выборе подсказки
                */
                formatSelected: function(suggestion) {
                    //Вернём правильный результат
                    return suggestion.value;
                }
            }));  
        }
        
        if (global.dadata_config.surname_show_hint){
            
            /**
            * Включает подсказки в Наименовании компании 
            */
            $("[name^='reg_surname'], [name='surname']").suggestions($.extend(init_params, {
                type           : "NAME",
                gender         : "UNKNOWN",
                params: {
                    parts: ["SURNAME"] //Поле Фамилия
                },
                /*
                * Возвращает строку для вставки в поле ввода при выборе подсказки
                */
                formatSelected: function(suggestion) {
                    //Вернём правильный результат
                    return suggestion.value;
                }
            }));  
        }
        
        if (global.dadata_config.name_show_hint){
            /**
            * Включает подсказки в Наименовании компании 
            */
            $("[name^='reg_name'], [name='name']").suggestions($.extend(init_params, {
                type           : "NAME",
                gender         : "UNKNOWN",
                params: {
                    parts: ["NAME"] //Поле Фамилия
                },
                /*
                * Возвращает строку для вставки в поле ввода при выборе подсказки
                */
                formatSelected: function(suggestion) {
                    //Вернём правильный результат
                    return suggestion.value;
                }
            }));  
        }
        
        if (global.dadata_config.midname_show_hint){
            /**
            * Включает подсказки в Наименовании компании 
            */
            $("[name^='reg_midname'], [name='midname']").suggestions($.extend(init_params, {
                type           : "NAME",
                gender         : "UNKNOWN",
                params: {
                    parts: ["PATRONYMIC"], //Поле Фамилия 
                },
                /*
                * Возвращает строку для вставки в поле ввода при выборе подсказки
                */
                formatSelected: function(suggestion) {
                    //Вернём правильный результат
                    return suggestion.value;
                }
            }));  
        }
        
        
        

        if (global.dadata_config.company_show_hint){
            /**
            * Включает подсказки в Наименовании компании
            */
            $("[name='reg_company'], [name='company']").suggestions($.extend(init_params, {
                serviceUrl     : "//dadata.ru/api/v2",
                count          : global.dadata_config.count ? global.dadata_config.count : 5,
                token          : global.dadata_config.api_key,
                partner        : "READYSCRIPT.ZAKUSILO",
                hint           : false,
                addon          : 'none', //Не показывать в правом углу ничего лишнего
                deferRequestBy : 100, //Задержка между запросами
                minChars       : 2, //Минимальное количество символов
                type           : "PARTY",

                /*
                * Возвращает строку для вставки в поле ввода при выборе подсказки
                */
                formatSelected: function(suggestion) {
                    if (global.dadata_config.company_inn_input && $("[name='reg_company_inn']").length){
                        //Вставим ИНН компании
                        $("[name='reg_company_inn']").val(suggestion.data.inn);
                    }
                    //Вернём правильный результат
                    return suggestion.value;
                }
            }));
        }
        
        
        if (global.dadata_config.email_show_hint){
            /**
            * Включает подсказки в E-mail
            */
            $("[name^='reg_e_mail'], [name^='user_email'], [name='e_mail']").suggestions($.extend(init_params, {
                suggest_local  : global.dadata_config.email_show_all ? false : true,
                type           : "EMAIL",
                /*
                * Возвращает строку для вставки в поле ввода при выборе подсказки
                */
                formatSelected: function(suggestion) {
                    //Вернём правильный результат
                    return suggestion.value;
                }
            }));  
        }
          
        
        if (global.dadata_config.city_show_hint){
            /**
            * Включает подсказки в городе
            */
            $("[name^='addr_city'], [name^='address[city]']").suggestions($.extend(init_params, {
                type : "ADDRESS",
                geoLocation : (global.dadata_config.geolocation_field_write && !global.dadata_config.use_only_address) ? true : false,
                /*
                * Возвращает строку для вставки в поле ввода при выборе подсказки
                */
                formatSelected: function(suggestion) {
                    //Вернём правильный результат
                    return suggestion.data.city;
                }
            }));  
        }    
        
        if (global.dadata_config.address_show_hint){
            var arr_city = $("[name^='addr_city']").length ? $("[name^='addr_city']") : $("[name^='address[city]']");

            var addr_address_options = {
                type           : "ADDRESS",
                /*
                * Возвращает строку для вставки в поле ввода при выборе подсказки
                */
                formatSelected: function(suggestion) {
                    //Получим возвращаемый адрес с адресом улицы и дома
                    var address = [];
                    if (global.dadata_config.use_only_address && suggestion.data.postal_code){
                        address.push(suggestion.data.postal_code);
                    }
                    if (global.dadata_config.use_only_address && suggestion.data.country){
                        address.push(suggestion.data.country);
                    }
                    if (global.dadata_config.use_only_address && suggestion.data.region_with_type){
                        address.push(suggestion.data.region_with_type);
                    }
                    address.push(suggestion.data.street_with_type);
                    //Если указан дом
                    if (suggestion.data.house){
                        address.push(suggestion.data.house);
                    }
                    if (suggestion.data.block_type){
                        address.push(suggestion.data.block_type+" "+suggestion.data.block);
                    }
                    if (suggestion.data.flat_type){
                        address.push(suggestion.data.flat_type+" "+suggestion.data.flat);
                    }
                    if (global.dadata_config.use_only_address && suggestion.data.city){
                        arr_city.val(suggestion.data.city);
                    }
                    //Если есть ZIP код и поле не заполнено, то заполним его самостоятельно.
                    var zip_code = $("[name^='addr_zipcode']").length ? $("[name^='addr_zipcode']") : $("[name^='address[zipcode]']")
                    if (zip_code.length && suggestion.data.postal_code.length && !zip_code.val().length){
                        zip_code.val(suggestion.data.postal_code);
                    }
                    //Вернём правильный результат
                    return address.length ? address.join(', ') : suggestion.data.value;
                }
            };

            //Если нужно ограничить поиск по городу
            if (arr_city.length && !global.dadata_config.use_only_address){
                addr_address_options['constraints'] = arr_city;
            }

            if (global.dadata_config.use_only_address){
                addr_address_options['geoLocation'] = false;
            }

            /**
            * Включает подсказки в адресе, вставляет улицу, дом и квартиру
            */
            $("[name^='addr_address'], [name^='address[address]']").suggestions($.extend(init_params, addr_address_options));
        }
    } 
    
    //Привяжем всё      
    dadataBindHints();
    
    
    
    //Если обновился контент, то заново привяжем
    /*$(window).on('new-content', function(){
        dadataBindHints();
    });*/
    
});
