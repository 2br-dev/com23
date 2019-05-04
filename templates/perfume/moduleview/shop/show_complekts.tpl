{assign var=shop_config value=ConfigLoader::byModule('shop')}
{assign var=check_quantity value=$shop_config.check_quantity}
<h2 class="dialogTitle" data-dialog-options='{ "width": "734" }'>{t}Выбор комплектации{/t}</h2>
<div class="multiComplectations">
    <section class="productPreview{if !$product->isAvailable()} notAvaliable{/if}{if $product->canBeReserved()} canBeReserved{/if}{if $product.reservation == 'forced'} forcedReserve{/if}" data-id="{$product.id}">
        <h1 class="fn">{$product.title}</h1>
        
        <div class="leftColumn">
            <div class="image">
                {$main_image=$product->getMainImage()}
                <img src="{$main_image->getUrl(327, 322)}" class="photo" alt="{$main_image.title|default:"{$product.title}"}"/>
            </div>
            {if $product.barcode}
                <p class="barcode"><span class="cap">{t}Артикул{/t}:</span> <span class="offerBarcode">{$product.barcode}</span></p>
            {/if}
            {if $product.short_description}
                <p class="descr">{$product.short_description|nl2br}</p>
            {/if}
            <div class="price">
                {assign var=last_price value=$product->getOldCost()}
                {if $last_price>0}<p class="lastPriceWrap"><span class="lastPrice">{$last_price}</span> {$product->getCurrency()}</p>{/if}
                <span class="price"><span class="myCost">{$product->getCost()}</span> {$product->getCurrency()}</span>
            </div>
        </div>
        
        <div class="information">
            {include "%catalog%/product_offers.tpl" preview_width="327" preview_height="322" preview_scale="xy"}
            
            {if $shop_config}
                {* Блок с сопутствующими товарами *}
                {moduleinsert name="\Shop\Controller\Block\Concomitant"}
            {/if}
            
            {* Вывод наличия на складах *}
            {assign var=stick_info value=$product->getWarehouseStickInfo()}
            {if !empty($stick_info.warehouses)}
                <div class="warehouseDiv">
                    <div class="title">{t}Наличие{/t}:</div>
                    {foreach from=$stick_info.warehouses item=warehouse}
                        <div class="warehouseRow" data-warehouse-id="{$warehouse.id}">
                            <div class="stickWrap">
                            {foreach from=$stick_info.stick_ranges item=stick_range}
                                 {$sticks=$product.offers.items.0.sticks[$warehouse.id]}
                                 <span class="stick {if $sticks>=$stick_range}filled{/if}"></span>          
                            {/foreach}
                            </div>
                            <a class="title" href="{$warehouse->getUrl()}"><span>{$warehouse.title}</span></a>
                        </div>
                    {/foreach}
                </div>
            {/if}            

            <div class="buttons">
                    <a data-href="{$router->getUrl('shop-front-reservation', ["product_id" => $product.id])}" class="inDialog reserve hidden">{t}заказать{/t}</a>
                    <span class="unobtainable hidden">{t}Нет в наличии{/t}</span>
                    <a data-href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="toBasket addToCart noShowCart">{t}В корзину{/t}</a>
            </div>
        </div>            
        <br class="clearboth">
        
    </section>
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