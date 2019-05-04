{addjs file="jquery.changeoffer.js"}
{$shop_config=ConfigLoader::byModule('shop')}
{$check_quantity=$shop_config.check_quantity}

{if $no_query_error}
<div class="noQuery">
    Не задан поисковый запрос
</div>      
{else}
<div id="products" {if $shop_config}class="shopVersion"{/if}>
    {if !empty($query)}
        <h1>Результаты поиска</h1>
    {else}
    	{if count($sub_dirs)}       		
    	{else}
    	<h1>{$category.name}</h1>
    	{/if}
    {/if}

    {* Фильтр *}
    {if $category.name == "Кулеры"}
	{moduleinsert name="\Catalog\Controller\Block\SideFilters"}
	{/if}

    {if $category.description}<article class="categoryDescription">{$category.description}</article>{/if}
    {* {if count($sub_dirs)}{assign var=one_dir value=reset($sub_dirs)}{/if}
    {if empty($query) || (count($sub_dirs) && $dir_id != $one_dir.id)}
    <nav class="subCategory">
        {foreach $sub_dirs as $item}
        <a href="{urlmake category=$item._alias p=null f=null bfilter=null}">{$item.name}</a>
        {/foreach}
    </nav>
    {/if} *}
	
    {if count($list)}
    <!--<div class="sortLine">		
        <div class="viewAs">
            <a href="{urlmake viewAs=table}" class="viewAs table{if $view_as == 'table'} act{/if}"></a>
            <a href="{urlmake viewAs=blocks}" class="viewAs blocks{if $view_as == 'blocks'} act{/if}"></a>                
        </div> 
		<div class="cb"></div>
    </div>-->  

    {if count($sub_dirs)}
    	{foreach $sub_dirs as $sd}
    	<h1 class="mt40">{$sd.name}</h1>
    	<ul class="products">
    		{foreach $list as $product}
            	{if $product->getMainDir()->name == $sd.name}
            		<li {$product->getDebugAttributes()} data-id="{$product.id}">
						<a href="{$product->getUrl()}" class="title">{$product.title}</a>								   
	                    <a href="{$product->getUrl()}" class="image">{if $product->inDir('new')}<i class="new"></i>{/if}<img src="{$product->getMainImage(138,185)}"></a>
	                    <!--Блок цен для товаров из категории Вода в таре 19 л.-->                    
	                    {if $product->getMainDir()->name == 'Вода в таре 19 л.'}										
							<div class="price">
								{if ($product->getCost('Цена от 2-х бутылей') !== '0') || ($product->getCost('Цена от 4-х бутылей') !== '0')}
									<div class="price1">						
										<p class="price1__price">{$product->getCost('Цена от 4-х бутылей')} {$product->getCurrency()}</p>
										<p class="price1__desc">от 4-х бут.</p>
									</div>
										{if $product->getCost('Цена от 2-х бутылей') !== '0'}
											<div class="price2">
												<p class="price2__price">{$product->getCost('Цена от 2-х бутылей')} {$product->getCurrency()}</p>
												<p class="price2__desc">от 2-х бут.</p>	
											</div>
										{/if}
										{if $product->getCost() !== '0'}
											<div class="price3">
												<p class="price3__price">{$product->getCost()} {$product->getCurrency()}</p>
												<p class="price3__desc">1 бут.</p>
											</div>
										{/if}
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
						<!--Блок цен для товаров из категории Вода в мелкой таре (меньше 19 л)-->	
						{elseif $product->getMainDir()->name == 'Вода в мелкой таре (меньше 19 л)'}
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
								{if $product->getPropertyValueByTitle('Цена от 4-х бутылей') !== '0'}
								<div class="price3">
									<p class="price3__price">{$product->getCost()} {$product->getCurrency()}</p>
									<p class="price3__desc">1 бут.</p>
								</div>
								{/if}
								<div class="cb" style="margin-bottom: 55px;"></div>					
								
								{else}
								<div class="price1">
									<p class="price1__price">{$product->getCost()} {$product->getCurrency()}</p>
									<p class="price1__desc" style="margin-bottom: 115px;">от {$product.min_order} бут.</p>
								</div>
								{/if}
								<a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="Купить">Купить</a>
							</div>
							<div class="amountBlock">
								<a class="minusButton amountButton fleft" data-id="{$product.id}" data-min="{$product.min_order}">-</a>
								<input id="amount{$product.id}" type="text" name="amount" class="amount fleft" {if $product.min_order != 0} value="{$product.min_order}" {else}value="1"{/if} data-id="{$product.id}" data-min="{$product.min_order}">	
								<a class="plusButton amountButton fleft" data-id="{$product.id}" data-min="{$product.min_order}">+</a>
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
										{else}
	                                    
										{/if}
	                                {/if}                                                            
	                            {/if}
	                        {/if}
	                    {/if}
					</li>
            	{/if}
            {/foreach}
        </ul>
        <div class="cb"></div>
        {if $sd.name == 'Вода в таре 19 л.'}
        	</div>
        	</div>
        	<div class="bbdot"></div>
        	<div class="productList mainContent">
        	<div id="products" {if $shop_config}class="shopVersion"{/if}>
        {/if}  
    	{/foreach}
    {else}    	
    	<ul class="products">
            {foreach $list as $product}            	         	
                <li {$product->getDebugAttributes()} data-id="{$product.id}">
					<a href="{$product->getUrl()}" class="title">{$product.title}</a>								   
                    <a href="{$product->getUrl()}" class="image">{if $product->inDir('new')}<i class="new"></i>{/if}<img src="{$product->getMainImage(138,185)}"></a>
                    <div class="price">						
						<div class="price1" style="text-align: left;">
							<p class="price1__price">{$product->getCost(null, null, true, false)}</p>
							<p class="price_kuler_currency">руб.</p>
							{if $product->getMainDir()->name == "Кулеры"}
							<p class="price1_desc" style="font-size: 1.4rem; margin-bottom: 5px;">{$product->getPropertyValueByTitle("Тип кулера")}</p>
							<p class="price1_desc" style="font-size: 1.4rem;">{$product->getPropertyValueByTitle("Тип охлаждения")}</p>
							<a class="products_more" href="{$product->getUrl()}">Подробнее</a>
							{/if}							
						</div>					
						<a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="Купить">Купить</a>
					</div>                   
					{$last_price=$product->getCost('Зачеркнутая цена')}
					{if $last_price>0}<span class="last">{$last_price} {$product->getCurrency()}</span>{/if}										
					
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
                                    <!--<a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="Купить">Купить</a>-->									
                                {/if}                                                            
                            {/if}
                        {/if}
                    {/if}
				</li>				
           {/foreach}
        </ul>
        <div class="cb"></div>
    {/if}    
    
    {include file="%THEME%/paginator.tpl"}
    
    {else}    
        <div class="noProducts">
            {if !empty($query)}
            Извините, ничего не найдено
            {else}
            В данной категории нет ни одного товара
            {/if}
        </div>
    {/if}
</div>
{/if}