<li {$product->getDebugAttributes()} data-id="{$product.id}">
    <!--<p>{$product->getMainDir()->name}</p>-->
    <a href="{$product->getUrl()}" class="title">{$product.title}</a>
    <a href="{$product->getUrl()}" class="image">{if $product->inDir('new')}<i class="new"></i>{/if}<img src="{$product->getMainImage(188,258)}"></a>
    {if $product->getMainDir()->name == 'Вода'}
        <!--Блок цен для товаров из категории Вода-->
        <div class="price" style="text-align: center; margin-top: 10px;">
            {if ($product->getCost('Цена от 2-х бутылей') != 0) || ($product->getCost('Цена от 4-х бутылей') != 0)}
                <div class="price1">
                    <p style="margin-bottom: 3px; font-style: italic;">за 1</p>
                    <p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getCost()} {$product->getCurrency()}</p>
                </div>
                {if $product->getCost('Цена от 2-х бутылей') != 0}
                    <div class="price2">
                        <p style="margin-bottom: 3px; font-style: italic;">от 2-х</p>
                        <p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getCost('Цена от 2-х бутылей')} {$product->getCurrency()}</p>
                    </div>
                {/if}
                {if $product->getCost('Цена от 4-х бутылей') != 0}
                    <div class="price3">
                        <p style="margin-bottom: 3px; font-style: italic;">от 4-х</p>
                        <p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getCost('Цена от 4-х бутылей')} {$product->getCurrency()}</p>
                    </div>
                {/if}
                <div class="cb"></div>
                {if $product.id !=='196' && $product.id !== '255'}
                    <p style="font-size: 11px; font-style: italic; margin-top: 5px; margin-bottom: 15px; padding: 0 15px;">стоимость воды при наличии оборотной тары</p>
                {/if}
            {else}
                <p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getCost()} {$product->getCurrency()}</p>
            {/if}
        </div>
    {elseif $product->getMainDir()->name == 'Вода в анапе'}
        <!--Блок цен для товаров из категории Вода в Анапе-->
        <div class="price" style="text-align: center; margin-top: 10px;">
            {if ($product->getCost('Цена от 2-х бутылей') != 0) || ($product->getCost('Цена от 4-х бутылей') != 0)}
                <div class="price1">
                    <p style="margin-bottom: 3px; font-style: italic;">за 1</p>
                    <p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getCost()} {$product->getCurrency()}</p>
                </div>
                {if $product->getCost('Цена от 2-х бутылей') != 0}
                    <div class="price2">
                        <p style="margin-bottom: 3px; font-style: italic;">от 2-х</p>
                        <p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getCost('Цена от 2-х бутылей')} {$product->getCurrency()}*</p>
                    </div>
                {/if}
                {if $product->getCost('Цена от 4-х бутылей') != 0}
                    <div class="price3">
                        <p style="margin-bottom: 3px; font-style: italic;">от 3-х</p>
                        <p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getCost('Цена от 4-х бутылей')} {$product->getCurrency()}*</p>
                    </div>
                {/if}
                <div class="cb"></div>
            {else}
                <p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getCost()} {$product->getCurrency()}</p>
            {/if}
            {if $product.id != '203'}
                <p style="font-size: 11px; font-style: italic; margin-top: 5px; padding: 0 15px;">Цена при наличии оборотной тары</p>
            {/if}
        </div>
    {else}
        <p class="price" style="font-size: 18px; font-weight: bold; text-align: center; margin-top: 10px;">{$product->getCost()} {$product->getCurrency()}
            {$last_price=$product->getCost('Зачеркнутая цена')}
            {if $last_price>0}<span class="last">{$last_price} {$product->getCurrency()}</span>{/if}
        </p>
    {/if}
    {if $product->getMainDir()->name == 'Кулеры'}
        <a class="compare{if $product->inCompareList()} inCompare{/if}"><span>Сравнить</span><span class="already">Сравнить</span></a>
    {/if}
    {if $shop_config}
        {if $product->shouldReserve()}
            <a href="{$router->getUrl('shop-front-reservation', ["product_id" => $product.id])}" class="button reserve inDialog">Заказать</a>
        {else}
            {if $check_quantity && $product.num<1}
                <span class="noAvaible">Нет в наличии</span>
            {else}
                {if $product->isOffersUse() || $product->isMultiOffersUse()}
                    <span data-href="{$router->getUrl('shop-front-multioffers', ["product_id" => $product.id])}" class="button showMultiOffers inDialog noShowCart">Купить</span>
                {else}
                    {if $product->getMainDir()->name == 'Вода в анапе'}
                        <p style="margin-top: 10px;"><strong>Заказ по телефону<br>
                                8(918) 33-33-222</strong>
                        </p>
                        {if $product.id != '203'}
                            <p style="font-size: 11px; font-style: italic; margin-top: 5px; padding: 0 15px;">* - Скидка от количества бутылей действительна для г. Анапа, п. Су-Псех, ст. Анапская</p>
                        {/if}

                    {else}
                        {if $catalog_config.buyinoneclick }
                            <a data-href="{$router->getUrl('catalog-front-oneclick',["product_id"=>$product.id])}" title="Купить в 1 клик" class="button buyOneClick inDialog">Купить в 1 клик</a>
                        {/if}

                       {* {if $eridan_config.discount_product_id == $product.id}
                           <a href="{$router->getUrl('eridan-front-actions', ["id" => $product.id])}" class="button addToCart noShowCart">В корзину</a>
                       {/if} *}
                        <a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="В корзину">В корзину</a>

                        <div class="cb"></div>

                    {/if}
                {/if}
            {/if}
        {/if}
    {/if}
</li>