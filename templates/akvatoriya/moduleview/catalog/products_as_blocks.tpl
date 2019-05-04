{$eridan_config=ConfigLoader::byModule('eridan')}
<ul class="products">
    {if $category.name == 'Сопутствующие товары' && count($sub_dirs)}
        {foreach $sub_dirs as $item}
            <li>
                <a href="{urlmake category=$item._alias p=null f=null bfilter=null}" class="title">{$item.name}</a>
                <a href="{$item->getUrl()}" class="image" style="margin-bottom: 60px;"><img src="{$item->getMainImage(250,358)}"></a>
                <a href="{$item->getUrl()}" title="Перейти в категррию {$category.name}" class="button buyOneClick inDialog">Перейти</a>
            </li>
        {/foreach}
    {/if}
    <!-- Товары с флагом - В наличии = 1 -->
    {foreach $list as $product}
        {if $product->getMainDir()->name == $category.name}
            {if $product.inStock == 1}
                {include file="%catalog%/block_one_product.tpl" eridan_config=$eridan_config}
            {/if}
        {/if}
    {/foreach}

    <!-- Товары с флагом - В наличии = 0 -->
    {foreach $list as $product}
        {if $product.inStock == 0}
            <li {$product->getDebugAttributes()} data-id="{$product.id}" style="position: relative;">
                <div class="notInStock__message">Нет в наличии</div>
                <div class="notInStock">
                    <a href="{$product->getUrl()}" class="title">{$product.title}</a>
                    <a href="{$product->getUrl()}" class="image">{if $product->inDir('new')}<i class="new"></i>{/if}<img src="{$product->getMainImage(188,258)}"></a>


                    {if $shop_config}
                        {if $product->shouldReserve()}
                            <a href="{$router->getUrl('shop-front-reservation', ["product_id" => $product.id])}" class="button reserve inDialog">Заказать</a>
                        {else}
                            {if $check_quantity && $product.num<1}
                                <span class="noAvaible">Нет в наличии</span>
                            {else}
                                {if $product->isOffersUse() || $product->isMultiOffersUse()}
                                    <!--<span data-href="{$router->getUrl('shop-front-multioffers', ["product_id" => $product.id])}" class="button showMultiOffers inDialog noShowCart">Купить</span>-->
                                {else}
                                    {if $product->getMainDir()->name == 'Вода в анапе'}
                                        <!--<p style="margin-top: 10px;"><strong>Заказ по телефону<br>
                                        8(918) 33-33-222</strong>
                                        </p>-->
                                    {else}
                                        <!--<a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="Купить">Купить</a>-->
                                    {/if}
                                {/if}
                            {/if}
                        {/if}
                    {/if}
                </div>
            </li>
        {/if}
    {/foreach}
</ul>