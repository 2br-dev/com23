<div class="oneClickWrapper">
    {if $success}
        <div class="authorization reserveForm">
            <h1 data-dialog-options='{ "width": "400" }'>Заказ принят</h1>
            <div class="infotext white">
                <p class="title">{$product.title}<br>
                Артикул:{$product.barcode}</p>            
                В ближайшее время с Вами свяжется наш менеджер
            </div>
        </div>    
    {else}
        <form enctype="multipart/form-data" method="POST" action="{$router->getUrl('catalog-front-oneclick',["product_id"=>$product.id])}" class="authorization formStyle reserveForm">
           {$this_controller->myBlockIdInput()}
           <input type="hidden" name="product_name" value="{$product.title}"/>
           <h1 data-dialog-options='{ "width": "400" }'>Купить в один клик</h1> 
           <div class="oneclick__productInfo">              
              <p><strong>Наименование товара: </strong>{$product.title}</p>
           </div>              
           <p class="infotext">
                Оставьте Ваши данные и наш консультант с вами свяжется для уточнения деталей заказа.
           </p>             
           <div class="forms">               
               {if $error_fields}
                   <div class="pageError"> 
                   {foreach $error_fields as $error_field}
                       {foreach $error_field as $error}
                            <p>{$error}</p>
                       {/foreach}
                   {/foreach}
                   </div>
               {/if}
                  {if $product->isMultiOffersUse()}
                        <div class="formLine">
                            {$product.offer_caption|default:'Комплектация'}
                        </div>
                        {assign var=offers_levels value=$product.multioffers.levels} 
                        {foreach $offers_levels as $level}
                            <div class="formLine">
                                <label class="fieldName">{if $level.title}{$level.title}{else}{$level.prop_title}{/if}</label>
                                <select name="multioffers[{$level.prop_id}]" data-prop-title="{if $level.title}{$level.title}{else}{$level.prop_title}{/if}">
                                   {foreach $level.values as $value}       
                                       {if $level.title}
                                            {assign var=ltitle value=$level.title}
                                       {else}
                                            {assign var=ltitle value=$level.prop_title}
                                       {/if} 
                                       {$concat="{$ltitle}: {$value.val_str}"}
                                       <option {if in_array($concat, $offer_fields.multioffer )}selected="selected"{/if} value="{$ltitle}: {$value.val_str}">{$value.val_str}</option> 
                                   {/foreach}
                                </select>
                            </div>
                        {/foreach}
                   {elseif $product->isOffersUse()}
                        {assign var=offers value=$product.offers.items}
                        <div class="formLine">
                            <label class="fieldName">{$product.offer_caption|default:'Комплектация'}</label>
                            <select name="offer">
                               {foreach $offers as $offer}
                                   <option value="{$offer.title}" {if $offer_fields.offer == $offer.title}selected="selected"{/if}>{$offer.title}</option> 
                               {/foreach}
                            </select>
                        </div>
                   {/if}                   
                   <div class="formLine">
                        <label class="fieldName">Ваше имя</label>
                        <input type="text" class="inp {if $error_fields}has-error{/if}" value="{if $request->request('name','string')}{$request->request('name','string')}{else}{$click.name}{/if}" maxlength="100" name="name">
                    </div>
                    <div class="formLine">
                        <label class="fieldName">Телефон</label>
                        <input type="text" class="inp {if $error_fields}has-error{/if}" value="{if $request->request('phone','string')}{$request->request('phone','string')}{else}{$click.phone}{/if}" maxlength="20" name="phone">
                    </div>                
                   {foreach $oneclick_userfields->getStructure() as $fld}
                   <div class="formLine">
                        <label class="fieldName">{$fld.title}</label>
                        {$oneclick_userfields->getForm($fld.alias)}
                    </div>

                    {/foreach}
                    <p>Для удобства управления и отслеживания статуса заказа укажите, пожалуйста, свою действующую электронную почту</p>
                    {if !$is_auth}
                    <div class="formLine captcha">
                        <label class="fieldName">Введите код, указанный на картинке</label>
                        <img height="42" width="100" src="{$router->getUrl('kaptcha', ['rand' => rand(1, 9999999)])}">
                        <input type="text" name="kaptcha" class="kaptcha">
                    </div>
                   {/if} 

                  <div class="personal">
			           <input type="checkbox" id="personal_chk"><label for="personal_chk">Нажимая кнопку «Купить», я принимаю условия <a href="http://com23.ru/o-kompanii/polzovatelskoe-soglashenie/" target="_blank">Пользовательского соглашения</a> и даю своё <a href="http://com23.ru/o-kompanii/obrabotka-personalnyh-dannyh/#sogl" target="_blank">согласие на обработку  персональных данных</a> ООО "Акватория" и ИП Картамышева А.А., в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных <a href="http://com23.ru/o-kompanii/politika-konfedencialnosti/" target="_blank">Политикой конфиденциальности</a> и <a href="http://com23.ru/o-kompanii/obrabotka-personalnyh-dannyh/#polit" target="_blank">Политикой в отношении обработки персональных данных</a></label>
			           <p class="personal_notice">Для продолжения Вы должны принять условия Пользовательского соглашения</p>
			       </div>

                   <div class="buttons">
                        <input type="submit" value="Купить" class="btn_disabled" disabled>
                   </div>
               </div>

               <script type="text/javascript">
    		        $(function() {		            
    		            $('#personal_chk').click(function(){
    		                if ($(this).prop('checked')){
    		                    $('form.reserveForm input[type="submit"]').removeAttr('disabled');
    		                    $('form.reserveForm input[type="submit"]').removeClass('btn_disabled');
    		                    $('.personal_notice').css('display', 'none');
    		                }
    		                else{
    		                    $('form.reserveForm input[type="submit"]').attr('disabled', 'disabled');
    		                    $('form.reserveForm input[type="submit"]').addClass('btn_disabled');
    		                    $('.personal_notice').css('display', 'block');
    		                }
    		            });

                    $('input[name="phone"]').mask("+7 (999) 999-9999");
    		            
    		        });        
    		    </script>    

        </form>
    {/if}
</div>