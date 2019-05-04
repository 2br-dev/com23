{if count($products)}
<div class="block lastViewed">
    <p class="blockTitle">Вы смотрели</p>
    <ul>
        {foreach $products as $product}
        <li>
			<a href="{$product->getUrl()}" title="{$product.title} {$product->getCost()} {$product->getCurrency()}"><img src="{$product->getMainImage()->getUrl(78,109, 'xy')}"></a>

			<p style="text-align: center; font-family: Arial; color: #002095; font-style: italic; font-size: 10px;">
                {if $product.inStock == 1}
				    {$product->getCost()} {$product->getCurrency()}
                {else}
                    Нет в наличии
                {/if}
			</p>
		</li>
        {/foreach}
    </ul>
</div>

<div class="block lastViewedMobile">
    <p class="blockTitle">Вы смотрели</p>
    <div class="lastViewedMobileSlider" id="lastViewedMobile">
        {foreach $products as $product}
        <div>
            <a href="{$product->getUrl()}" title="{$product.title} {$product->getCost()} {$product->getCurrency()}"><img src="{$product->getMainImage()->getUrl(78,109, 'xy')}"></a>
            <p style="text-align: center; font-family: Arial; color: #002095; font-style: italic; font-size: 10px;">
                {if $product.inStock == 1}
                    {$product->getCost()} {$product->getCurrency()}
                {else}
                    Нет в наличии
                {/if}
            </p>
        </div>
        {/foreach}
    </div>
</div>
{/if}