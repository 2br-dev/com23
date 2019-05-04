{if !empty($recommended)}
<section class="recommended">
    <h2>С этим товаром покупают</h2>
    <div class="previewList">
        <div class="gallery">
            <ul>
                {foreach from=$recommended item=product}
                <li>
					<a href="{$product->getUrl()}" title="{$product.title}" class="recommended-title">{$product->title}</a>
					<div class="recommended-img">
						<a href="{$product->getUrl()}" title="{$product.title}"><img src="{$product->getMainImage(92, 208)}"></a>
					</div>
					{if $product->getMainDir()->name == 'Вода'}
						{$product->fillProperty()|devnull}
						{if $last_price>0}<p class="lastPrice">{$last_price}</p>{/if}
						<!--<strong class="myCost">{$product->getCost()}</strong> {$product->getCurrency()}-->
						<div class="price" style="text-align: center; margin-top: 10px;">
							<div class="price1">
								<p style="margin-bottom: 3px; font-style: italic;">за 1</p>
								<p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getCost()} {$product->getCurrency()}</p>
							</div>
							<div class="price2">
								<p style="margin-bottom: 3px; font-style: italic;">от 2-х</p>
								<p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getPropertyValueByTitle('Цена от 2-х бутылей')} {$product->getCurrency()}</p>
							</div>
							<div class="price3">
								<p style="margin-bottom: 3px; font-style: italic;">от 4-х</p>
								<p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getPropertyValueByTitle('Цена от 4-х бутылей')} {$product->getCurrency()}</p>
							</div>
							<div class="cb"></div>
							<p style="font-size: 11px; font-style: italic; margin-top: 5px;">* - при наличии залоговой тары</p>
						</div>
					{else}
					<p class="price" style="font-size: 18px; font-weight: bold; text-align: center; margin-top: 10px;">{$product->getCost()} {$product->getCurrency()} 
							{$last_price=$product->getCost('Зачеркнутая цена')}
							{if $last_price>0}<span class="last">{$last_price} {$product->getCurrency()}</span>{/if}
						</p>
					{/if}
					
				</li>
                {/foreach}
            </ul>
			<div class="cb"></div>
        </div>
        <a class="control prev"></a>
        <a class="control next"></a>
    </div>
</section>
{/if}