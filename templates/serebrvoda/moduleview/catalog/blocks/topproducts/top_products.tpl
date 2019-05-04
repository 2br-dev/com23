{$products=$this_controller->api->addProductsProperty($products)}
{if $products}
<div class="leaders mainContent">
<!-- <noindex> -->	
	<div class="sliderVoda">
		{foreach $products as $product}
			{if $product->getMainDir()->name == "Вода в таре 19 л."}		
			<div class="products" {$product->getDebugAttributes()} data-id="{$product.id}" style="border: none !important;">
				<a href="{$product->getUrl()}" class="title">{$product.title}</a>
				<a href="{$product->getUrl()}" class="image">{if $product->inDir('new')}<i class="new"></i>{/if}<img src="{$product->getMainImage(138,185)}" alt="{$product.title}"></a>
				<div class="price">
				{if ($product->getPropertyValueByTitle('Цена от 2-х бутылей') !== '0') || ($product->getPropertyValueByTitle('Цена от 4-х бутылей') !== '0')}
					<div class="price1">						
						<p class="price1__price">{$product->getPropertyValueByTitle('Цена от 4-х бутылей')} {$product->getCurrency()}</p>
						<p class="price1__desc">от 4-х бут.</p>
					</div>
					{if $product->getPropertyValueByTitle('Цена от 2-х бутылей') !== '0'}
					<div class="price2">
						<p class="price2__price">{$product->getPropertyValueByTitle('Цена от 2-х бутылей')} {$product->getCurrency()}</p>
						<p class="price2__desc">от 2-х бут.</p>						
					</div>
					{/if}					
					<div class="price3">						
						<p class="price3__price">{$product->getCost()} {$product->getCurrency()}</p>
						<p class="price3__desc">1 бут.</p>
					</div>					
					<div class="cb"></div>
					<p class="without-tare">без учета стоимтости тары</p>
				{else}
					<div class="price1">
						<p class="price1__price" style="margin-bottom: 125px;">{$product->getCost()} {$product->getCurrency()}</p>
					</div>
				{/if}
					<a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="Купить">Купить</a>	
				</div>
				<div class="amountBlock">
					<a class="minusButton amountButton fleft" data-id="{$product.id}" data-min="{$product.min_order}">-</a>
					<input id="amount{$product.id}" type="text" name="amount" class="amount fleft" {if $product.min_order != 0} value="{$product.min_order}" {else}value="1"{/if} data-id="{$product.id}" data-min="{$product.min_order}">	
					<a class="plusButton amountButton fleft" data-id="{$product.id}" data-min="{$product.min_order}">+</a>
				</div>							
			</div>
			{elseif $product->getMainDir()->name == "Кулеры"}
			<div class="products" {$product->getDebugAttributes()} data-id="{$product.id}" style="border: none !important;">
				<a href="{$product->getUrl()}" class="title">{$product.title}</a>
				<a href="{$product->getUrl()}" class="image">{if $product->inDir('new')}<i class="new"></i>{/if}<img src="{$product->getMainImage(139,186)}" alt="{$product.title}"></a>
				<div class="price_kuler">				
					<p>{$product->getCost()}</p>
					<p class="price_kuler_currency">руб.</p>			
					<a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="Купить">Купить</a>	
				</div>												
			</div>
			{/if}                         
		{/foreach}    
	</div>
</div>
<!-- </noindex> -->	
{else}
    {include file="%THEME%/block_stub.tpl"  class="blockTopProducts" do=[
        [
            'title' => t("Добавьте категорию с товарами"),
            'href' => {adminUrl do=false mod_controller="catalog-ctrl"}
        ],
        [
            'title' => t("Настройте блок"),
            'href' => {$this_controller->getSettingUrl()},
            'class' => 'crud-add'
        ]
    ]}
{/if}