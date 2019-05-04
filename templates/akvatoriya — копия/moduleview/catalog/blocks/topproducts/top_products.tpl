{$products=$this_controller->api->addProductsProperty($products)}
{assign var=catalog_config value=$this_controller->getModuleConfig()}
{if $products}
<div class="leaders">
	<div class="sliderVoda" id="sliderVoda">
		{foreach $products as $product}
		{if $product.inStock == 1}
			<div class="products" {$product->getDebugAttributes()} data-id="{$product.id}" style="border: none !important;">
				<a href="{$product->getUrl()}" class="title">{$product.title}</a>
				<a href="{$product->getUrl()}" class="image">{if $product->inDir('new')}<i class="new"></i>{/if}<img src="{$product->getMainImage(110,205)}" alt="{$product.title}"></a>
				
				<div class="price">
				{if ($product->getCost('Цена от 2-х бутылей') != 0) || ($product->getCost('Цена от 4-х бутылей') != 0)}
					<div class="price1">
						<p style="margin-bottom: 3px; font-style: italic;">за 1</p>
						<p style="font-weight: bold; font-style: italic;">{$product->getCost()} {$product->getCurrency()} 
							{$last_price=$product->getCost('Зачеркнутая цена')}
							{if $last_price>0}<span class="last">{$last_price} {$product->getCurrency()}</span>{/if}
						</p>
					</div>
					{if $product->getCost('Цена от 2-х бутылей') != 0}
					<div class="price2">
						<p style="margin-bottom: 3px; font-style: italic;">от 2-х</p>
						<p style="font-weight: bold; font-style: italic;">{$product->getCost('Цена от 2-х бутылей')} {$product->getCurrency()}</p>
					</div>
					{/if}
					{if $product->getCost('Цена от 4-х бутылей') != 0}
					<div class="price3">
						<p style="margin-bottom: 3px; font-style: italic;">от 4-х</p>
						<p style="font-weight: bold; font-style: italic;">{$product->getCost('Цена от 4-х бутылей')} {$product->getCurrency()}</p>
					</div>
					{/if}
					<div class="cb"></div>
					<p style="font-size: 11px; font-style: italic; margin-top: 5px;">* - при наличии оборотной тары</p>
					{else}
						<p style="font-weight: bold; font-style: italic; font-size: 16px;">{$product->getCost()} {$product->getCurrency()}</p>
					{/if}
				</div>
				{if $catalog_config.buyinoneclick }
					<a data-href="{$router->getUrl('catalog-front-oneclick',["product_id"=>$product.id])}" title="Купить в 1 клик" class="button buyOneClick inDialog">Купить в 1 клик</a>
				{/if} 
				<a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="В корзину">В Корзину</a>									
			</div>
		{/if}                   
		{/foreach}    
	</div>
</div>
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