{assign var=shop_config value=ConfigLoader::byModule('shop')}
{assign var=check_quantity value=$shop_config.check_quantity}

<div class="authorization formStyle reserveForm">
    <h1 class="dialogTitle" data-dialog-options='{ "width": "630" }'>Выбор комплектации</h1>
    <div class="multiComplectations{if !$product->isAvailable()} notAvaliable{/if}" data-id="{$product.id}">
        <h4 class="fn">{$product.title}</h4>
        <div class="leftColumn">
            <div class="image">
                <img src="{$product->getMainImage()->getUrl(233, 310)}" class="photo">
            </div>
            {if $product.barcode}
                <p class="barcode"><span class="cap">Артикул:</span> <span class="offerBarcode">{$product.barcode}</span></p>
            {/if}
            {if $product.short_description}
                <p class="descr">{$product.short_description|nl2br}</p>
            {/if}
            <div class="fcost">
                {assign var=last_price value=$product->getCost('Зачеркнутая цена')}
                {if $last_price>0}<div class="lastPrice">{$last_price}</div>{/if}
                <span class="price"><strong class="myCost">{$product->getCost()}</strong> {$product->getCurrency()}</span>
            </div>
        </div>
        <div class="information">
            {if $product->isMultiOffersUse()}
                {* Многомерные комплектации *}
                <span class="pname">{$product.offer_caption|default:'Комплектация'}</span>
                <div class="multiOffers">
                    {foreach $product.multioffers.levels as $level}
                        {if !empty($level.values)}
                            <div class="title">{if $level.title}{$level.title}{else}{$level.prop_title}{/if}</div>
                            <select name="multioffers[{$level.prop_id}]" data-prop-title="{if $level.title}{$level.title}{else}{$level.prop_title}{/if}">
                                {foreach $level.values as $value}
                                    <option value="{$value.val_str}">{$value.val_str}</option>   
                                {/foreach}
                            </select>
                        {/if}
                    {/foreach}
                </div>
                {if $product->isOffersUse()}
                    {foreach from=$product.offers.items key=key item=offer name=offers}
                        <input value="{$key}" type="hidden" name="hidden_offers" class="hidden_offers" {if $smarty.foreach.offers.first}checked{/if} id="offer_{$key}" data-info='{$offer->getPropertiesJson()}' {if $check_quantity}data-num="{$offer.num}"{/if} data-change-cost='{ ".offerBarcode": "{$offer.barcode|default:$product.barcode}", ".myCost": "{$product->getCost(null, $key)}", ".lastPrice": "{$product->getCost('Зачеркнутая цена', $key)}"}'/>
                    {/foreach}
                    
                    <input type="hidden" name="offer" value="0"/>
                {/if}
            {elseif $product->isOffersUse()}
                {* Простые комплектации *}
                <div class="packages">
                    <div class="package">
                        <span class="pname">{$product.offer_caption|default:'Комплектация'}</span>
                        <div class="values">
                            {if count($product.offers.items)>5}
                                <select name="offer">
                                    {foreach from=$product.offers.items key=key item=offer name=offers}
                                    <option value="{$key}" {if $smarty.foreach.offers.first}checked{/if} data-num="{$offer.num}" data-change-cost='{ ".myCost": "{$product->getCost(null, $key)}", ".lastPrice": "{$product->getCost('Зачеркнутая цена', $key)}"}'>{$offer.title}</option>
                                    {/foreach}
                                </select>
                            {else}
                                {foreach from=$product.offers.items key=key item=offer name=offers}
                                    <input value="{$key}" type="radio" name="offer" {if $smarty.foreach.offers.first}checked{/if} id="offer_{$key}" data-num="{$offer.num}" data-change-cost='{ ".myCost": "{$product->getCost(null, $key)}", ".lastPrice": "{$product->getCost('Зачеркнутая цена', $key)}"}'>
                                    <label for="offer_{$key}">{$offer.title}</label><br>
                                {/foreach}
                            {/if}
                        </div>
                    </div>
                </div>
            {/if}

            <div class="buttons">
                {if $product->shouldReserve()}
                    <a href="{$router->getUrl('shop-front-reservation', ["product_id" => $product.id])}" class="inDialog reserve ">заказать</a>
                {else}
                    <span class="unobtainable">Нет в наличии</span>                
                    <a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart">В корзину</a>      
                {/if}
            </div>
        </div>            
    </div>
</div>

{literal}
    <script type="text/javascript">
        $(function() {
            $('[name="offer"]').changeOffer();
        });
        $('.multiComplectations .addToCart').on('click',function(){
            $.colorbox.close();
        });
    </script>
{/literal}