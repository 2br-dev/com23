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
           <p class="infotext">
                Оставьте Ваши данные и наш консультант с вами свяжется.
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
                    {if !$is_auth}
                    <div class="formLine captcha">
                        <label class="fieldName">Введите код, указанный на картинке</label>
                        <img height="42" width="100" src="{$router->getUrl('kaptcha', ['rand' => rand(1, 9999999)])}">
                        <input type="text" name="kaptcha" class="kaptcha">
                    </div>
                   {/if}                    
                   <div class="buttons">
                        <input type="submit" value="Купить">
                   </div>
               </div>
        </form>
    {/if}
</div>