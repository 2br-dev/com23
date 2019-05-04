<table class="productTable">
    {foreach $list as $product}
        <tr {$product->getDebugAttributes()} data-id="{$product.id}">
            <td class="image"><a href="{$product->getUrl()}"><img src="{$product->getMainImage()->getUrl(100,100)}"></a></td>
            <td class="info">
                <a href="{$product->getUrl()}" class="title">{$product.title}</a>
                {if $product.barcode}<p class="barcode">Артикул: {$product.barcode}</p>{/if}
                <p class="descr">{$product.short_description}</p>
            </td>
            <td class="price">{$product->getCost()} {$product->getCurrency()}</td>
            <td class="actions">
                {if $shop_config}
                    {if $product->shouldReserve()}
                        <a href="{$router->getUrl('shop-front-reservation', ["product_id" => $product.id])}" class="button reserve inDialog">Заказать</a>
                    {else}
                        {if $check_quantity && $product.num<1}
                            <div class="noAvaible">Нет в наличии</div>
                        {else}
                            {if $product->isOffersUse() || $product->isMultiOffersUse()}
                                <span data-href="{$router->getUrl('shop-front-multioffers', ["product_id" => $product.id])}" class="button showMultiOffers inDialog noShowCart">Купить</span>
                            {else}
                                <a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="Купить">Купить</a>
                            {/if}
                        {/if}
                    {/if}
                {/if}
                <a class="compare{if $product->inCompareList()} inCompare{/if}"><span>Сравнить</span><span class="already">Сравнить</span></a>
            </td>
        </tr>
    {/foreach}
</table>