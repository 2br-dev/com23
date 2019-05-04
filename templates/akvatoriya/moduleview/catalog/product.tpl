{addjs file="jcarousel/jquery.jcarousel.min.js"}
{addjs file="jquery.changeoffer.js"}
{addjs file="jquery.zoom.min.js"}
{addjs file="product.js"}
{assign var=shop_config value=ConfigLoader::byModule('shop')}
{assign var=check_quantity value=$shop_config.check_quantity}
{assign var=catalog_config value=$this_controller->getModuleConfig()}

<div class="product{if !$product->isAvailable()} notAvaliable{/if}" data-id="{$product.id}">
    <div class="productInfo">
        <!--<div class="ratingZone">
            <div class="social">
                <a class="handler"></a>
                <div class="socialLinks">
                    <i class="corner"></i>
                    <p class="caption">Поделиться с друзьями:</p>
                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                    <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir"></div>             
                </div>                        
            </div>
                                    
            <div class="rating">
                <span class="stars" title="Средняя оценка: {$product->getRatingBall()}"><i style="width:{$product->getRatingPercent()}%"></i></span>
                <a href="#comments" class="commentsCount">{t comments=$product->getCommentsNum()}%comments [plural:%comments:отзыв|отзыва|отзывов]{/t}</a>
            </div>
        </div>-->
        
        {** {moduleinsert name="Eridan\Controller\Block\NextDeliveryDate"} **}
        
        <h1>
        {if $product->getMainDir()->name == "Вода"}
        <span>Питьевая вода</span><br>
        {/if}
        {if $product->getMainDir()->name == "Кулеры"}
        <span>Кулер для воды</span><br>
        {/if}
        {$product.title}
        </h1>
		{if $product.short_description}
        <div class="shortDescription">{$product.short_description}</div>
        {/if}
        {if $product.barcode}
        <p class="attribute">Артикул: <span class="offerBarcode">{$product.barcode}</span></p>
        {/if}
        {if $product.brand_id}
        <p class="attribute">Производитель: <a class="brandTitle" href="{$product->getBrand()->getUrl()}">{$product->getBrand()->title}</a></p>
        {/if}                
        
        {* Подгружаем остатки по складам, т.к. при смене комплектации 
        будет изменяться и отображение остатков *}
        {$product->fillOffersStockStars()}        
        
        {if $product->isMultiOffersUse()}
            {* Многомерные комплектации *}
            <div class="multiOffers">
                <div class="pname">{$product.offer_caption|default:'Комплектация'}</div>
                {foreach $product.multioffers.levels as $level}
                    {if !empty($level.values)}
                        <div class="multiofferTitle">{if $level.title}{$level.title}{else}{$level.prop_title}{/if}</div>
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
                    <input value="{$key}" type="hidden" name="hidden_offers" class="hidden_offers" {if $smarty.foreach.offers.first}checked{/if} id="offer_{$key}" data-info='{$offer->getPropertiesJson()}' {if $check_quantity}data-num="{$offer.num}"{/if} data-change-cost='{ ".offerBarcode": "{$offer.barcode|default:$product.barcode}", ".myCost": "{$product->getCost(null, $key)}", ".lastPrice": "{$product->getCost('Зачеркнутая цена', $key)}"}' data-sticks='{$offer->getStickJson()}'/>
                {/foreach}
                <input type="hidden" name="offer" value="0"/>
            {/if}

        {elseif $product->isOffersUse()}
            {* Простые комплектации *}
            <div class="packages">
                <span class="pname">{$product.offer_caption|default:'Комплектация'}</span>
                <div class="values">
                    {if count($product.offers.items)>5}
                        <select name="offer">
                            {foreach from=$product.offers.items key=key item=offer name=offers}
                            <option value="{$key}" {if $smarty.foreach.offers.first}checked{/if} {if $check_quantity}data-num="{$offer.num}"{/if} data-change-cost='{ ".offerBarcode": "{$offer.barcode|default:$product.barcode}", ".myCost": "{$product->getCost(null, $key)}", ".lastPrice": "{$product->getCost('Зачеркнутая цена', $key)}"}' data-sticks='{$offer->getStickJson()}'>{$offer.title}</option>
                            {/foreach}
                        </select>
                    {else}
                        {foreach from=$product.offers.items key=key item=offer name=offers}
                            <input value="{$key}" type="radio" name="offer" {if $smarty.foreach.offers.first}checked{/if} id="offer_{$key}" {if $check_quantity}data-num="{$offer.num}"{/if} data-change-cost='{ ".offerBarcode": "{$offer.barcode|default:$product.barcode}", ".myCost": "{$product->getCost(null, $key)}", ".lastPrice": "{$product->getCost('Зачеркнутая цена', $key)}"}' data-sticks='{$offer->getStickJson()}'>
                            <label for="offer_{$key}">{$offer.title}</label><br>
                        {/foreach}
                    {/if}
                </div>
            </div>
        {/if}
		
		<!--Для карточки товара катигории "Вода"-->
		{if $product->getMainDir()->name == 'Вода' || $product->getMainDir()->name == 'Вода в анапе'}
			{assign var=last_price value=$product->getCost('Зачеркнутая цена')}
			<div style="width: 280px; float: left; padding-top: 50px;">
				{if $product.inStock == 1}
				<div class="price" >
						{if $last_price>0}<p class="lastPrice">{$last_price}</p>{/if}
						<!--<strong class="myCost">{$product->getCost()}</strong> {$product->getCurrency()}-->
						<div class="myCost-water" style="text-align: center; margin-top: 10px;">
							<div class="price1">
								<p style="margin-bottom: 3px; font-style: italic; font-size: 16px;">за 1</p>
								<p style="font-weight: bold; font-style: italic; font-size: 24px;">{$product->getCost()} {$product->getCurrency()}</p>
							</div>
							{if $product->getCost('Цена от 2-х бутылей') != 0}
							<div class="price2">
								<p style="margin-bottom: 3px; font-style: italic; font-size: 16px;">от 2-х</p>
								<p style="font-weight: bold; font-style: italic; font-size: 24px;">{$product->getCost('Цена от 2-х бутылей')} {$product->getCurrency()}</p>
							</div>
							{/if}
							{if $product->getCost('Цена от 4-х бутылей') != 0}
							<div class="price3">
								{if $product->getMainDir()->name == 'Вода в анапе'}
								<p style="margin-bottom: 3px; font-style: italic; font-size: 16px;">от 3-х</p>
								{else}
								<p style="margin-bottom: 3px; font-style: italic; font-size: 16px;">от 4-х</p>
								{/if}	
								<p style="font-weight: bold; font-style: italic; font-size: 24px;">{$product->getCost('Цена от 4-х бутылей')} {$product->getCurrency()}</p>
							</div>
							{/if}
							<div class="cb"></div>
							{if $product.id !=='196' && $product.id !== '255' && $product.id !== '203'}	
							<p style="font-size: 11px; font-style: italic; margin-top: 5px; text-align: left;">* - при наличии оборотной тары</p>
							{/if}
						</div>
				</div>
				{else}
				<div class="notInStock__message__productItem">Нет в наличии</div>
				{/if}
				<div class="buttons" style="margin: 0;">
					{if $product.inStock == 1}
					<div class="amountBlock">
						<a class="plusButton amountButton fleft"></a>
						<input type="text" name="amount" class="amount fleft" value="1">				
						<a class="minusButton amountButton fleft"></a>
					</div>
					{/if}
					{if $shop_config}
						{if $product->shouldReserve()}
							<a href="{$router->getUrl('shop-front-reservation', ["product_id" => $product.id])}" class="button reserve inDialog">Заказать</a>
						{else}        
							<span class="unobtainable">Нет в наличии</span>
							{if $product.inStock == 1}
								{if $catalog_config.buyinoneclick }
			                        <a data-href="{$router->getUrl('catalog-front-oneclick',["product_id"=>$product.id])}" title="Купить в 1 клик" class="button buyOneClick inDialog">Купить в 1 клик</a>
			                    {/if}  
								<a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="В корзину">В корзину</a>
							{/if}                    
						{/if}
					{/if}
					
					{if !$shop_config || (!$product->shouldReserve() && (!$check_quantity || $product.num>0))}
						{*{if $catalog_config.buyinoneclick }
							<a href="{$router->getUrl('catalog-front-oneclick',["product_id"=>$product.id])}" title="Купить в 1 клик" class="button buyOneClick inDialog">Купить в 1 клик</a>
						{/if}*}                        
					{/if}			
				</div>
			</div>
			{if $product.id !== '196' && $product.id !== '203'}
			<div style="float: left; margin-left: 80px;">
				<p style="font-family: Arial; color: #002095; text-transform: uppercase; margin-top: 20px; font-weight: bold; margin-bottom: 10px; text-align: center;">Сертификат соответствия</p>				
				<a href="{$product.__test_image->getUrl(887, 650, 'xy')}" class="cboxElement"><img src="{$product.__test_image->getUrl(214, 292, 'xy')}"/></a>
			</div>
			{/if}
			<div class="cb"></div>
			<div class="orang-line" style="margin-top: 30px;"></div>
			<div class="product__description">{$product.description}</div>
			
			
			
			
			{* Вывод наличия на складах *}
			{assign var=stick_info value=$product->getWarehouseStickInfo()}
			{if !empty($stick_info.warehouses)}
				<div class="warehouseDiv">
					<div class="titleDiv">Наличие:</div>
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
			
			{$tabs=[]}
			{$properties = $product->fillProperty()}        
			{if $properties || $product.offers.items} {$tabs["property"] = 'Характеристики'} {/if}
			        
			
			<!--<div class="tabs gray productTabs">
				<ul class="tabList">
					{foreach $tabs as $key=>$tab}
					{if $tab@first}{$act_tab=$key}{/if}
					<li {if $tab@first}class="act"{/if} data-href=".tab-{$key}"><a>{$tab}</a></li>
					{/foreach}
				</ul>
				
				{if $tabs.property}
				<div class="tab tab-property {if $act_tab == 'property'}act{/if}">
					{foreach $product.offers.items as $key=>$offer}
					{if $offer.propsdata}
					<div class="offerProperty propertyGroup{if $key>0} hidden{/if}" data-offer="{$key}">
						<p class="groupName">Характеристики комплектации</p>
						<table class="properties">
							{foreach $offer.propsdata as $pkey=>$pval}
							<tr>
								<td class="key"><span>{$pkey}</span></td>
								<td class="value"><span>{$pval}</span></td>
							</tr>
							{/foreach}
						</table>
					</div>
					{/if}
					{/foreach}            
				
					{foreach $product->fillProperty() as $data}
					
					<div class="propertyGroup">
						<!--<p class="groupName">{$data.group.title|default:"Характеристики"}</p>
						<table class="properties">
							{foreach $data.properties as $property}
							{if !$property.hidden && $property->textView() != ''}
							<tr>
								<td class="key"><span>{$property.title}</span></td>
								<td class="value"><span>{$property->textView()} {$property.unit}</span></td>
							</tr>
							{/if}
							{/foreach}
						</table>
					</div>
					
					{/foreach}            
				</div>
				{/if}
				
				{if $tabs.description}
				<div class="tab tab-description textStyle {if $act_tab == 'description'}act{/if}">
					<article>{$product.description}</article>
				</div>
				{/if}
			
				{if $tabs.comments}
				<div class="tab tab-comments {if $act_tab == 'comments'}act{/if}">
					<script type="text/javascript">
						$(function() {
							if (location.hash=='#comments') {
								$('.product .tabs .tab').removeClass('act');
								$('.product .tabs .tabList [data-href=".tab-comments"]').click();
							}
						});
					</script>
					{moduleinsert name="\Comments\Controller\Block\Comments" type="\Catalog\Model\CommentType\Product"}            
				</div>
				{/if}
			</div>-->
		<!--end-->
		
		<!--Карточка товара всех категорий - кроме "Вода"!!!!!-->
		{else}
			{assign var=last_price value=$product->getCost('Зачеркнутая цена')}
			{if $product.inStock == 1}
				<div class="price fleft" >
						{if $last_price>0}<p class="lastPrice">{$last_price}</p>{/if}
						<strong class="myCost">{$product->getCost()}</strong> {$product->getCurrency()}				
				</div>
				<div class="buttons" style="float: right;">
					{if $product->getMainDir()->name == 'Кулеры'}
						<a class="compare{if $product->inCompareList()} inCompare{/if}"><span>Сравнить</span><span class="already">Сравнить</span></a>
					{else if $product->getMainDir()->name == 'Вода'}
						<input type="text" name="amound" value="1">
					{/if}
					{if $shop_config}
						{if $product->shouldReserve()}
							<a href="{$router->getUrl('shop-front-reservation', ["product_id" => $product.id])}" class="button reserve inDialog">Заказать</a>
						{else}        
							<span class="unobtainable">Нет в наличии</span>
							{if $catalog_config.buyinoneclick }
		                        <a data-href="{$router->getUrl('catalog-front-oneclick',["product_id"=>$product.id])}" title="Купить в 1 клик" class="button buyOneClick inDialog" style="vertical-align: top; padding: 1px 10px;">Купить в 1 клик</a>
		                    {/if}  
							<a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart" data-add-text="Купить">Купить</a>                    
						{/if}
					{/if}
					
					{if !$shop_config || (!$product->shouldReserve() && (!$check_quantity || $product.num>0))}
						{*{if $catalog_config.buyinoneclick }
							<a href="{$router->getUrl('catalog-front-oneclick',["product_id"=>$product.id])}" title="Купить в 1 клик" class="button buyOneClick inDialog">Купить в 1 клик</a>
						{/if}*}                        
					{/if}				
				</div>
			{else}
				<div class="notInStock__message__productItem">Нет в наличии</div>
			{/if}
			<div class="cb"></div>
			{if $product->getMainDir()->name == 'Кулеры'}
				<div class="attantion-kuler">
					<div class="attention-image">
						<img src="{$THEME_IMG}/attantion-image.png">
					</div>
					<div class="attention-service">
						<a class="attantion__link" href="http://com23.ru/servis/#obrabotka">Кулер нуждается в регулярной сан. обработке<br>Узнать бльше >></a>
					</div>
					<div class="attention-instruction">
						<a class="attantion__link" href="{$THEME_IMG}/service/istructions kuler.pdf" target="_blank">Как правильно установить кулер<br>Инструкция >></a>
					</div>
				</div>
			{/if}	
			<div class="orang-line"></div>
			{* Вывод наличия на складах *}
			{assign var=stick_info value=$product->getWarehouseStickInfo()}
			{if !empty($stick_info.warehouses)}
				<div class="warehouseDiv">
					<div class="titleDiv">Наличие:</div>
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
			
			{$tabs=[]}
			{$properties = $product->fillProperty()}
			{if $product->getMainDir()->name == 'Кулеры' || $product->getMainDir()->name == 'Пурифайеры'}
				{if $properties || $product.offers.items} {$tabs["property"] = 'Характеристики'} {/if}
			{/if}
			{if $product.description} {$tabs["description"] = 'Описание'} {/if}        
			
			
			
			<div class="tabs gray productTabs">
				<ul class="tabList">
					{foreach $tabs as $key=>$tab}
					{if $tab@first}{$act_tab=$key}{/if}
					<li {if $tab@first}class="act"{/if} data-href=".tab-{$key}"><a>{$tab}</a></li>
					{/foreach}
				</ul>
				
				{if $tabs.property}
				<div class="tab tab-property {if $act_tab == 'property'}act{/if}">
					{** {foreach $product.offers.items as $key=>$offer}
					{if $offer.propsdata}
					<div class="offerProperty propertyGroup{if $key>0} hidden{/if}" data-offer="{$key}">
						<p class="groupName">Характеристики комплектации</p>
						<table class="properties">
							{foreach $offer.propsdata as $pkey=>$pval}
							<tr>
								<td class="key"><span>{$pkey}</span></td>
								<td class="value"><span>{$pval}</span></td>
							</tr>
							{/foreach}
						</table>
					</div>
					{/if}
					{/foreach} **}            
				
					{foreach $product->fillProperty() as $data}
					<div class="propertyGroup">
						<!--<p class="groupName">{$data.group.title|default:"Характеристики"}</p>-->
						<table class="properties">
							{foreach $data.properties as $property}
							{if !$property.hidden && $property->textView() != ''}
							<tr>
								<td class="key"><span>{$property.title}</span></td>
								<td class="value"><span>{$property->textView()} {$property.unit}</span></td>
							</tr>
							{/if}
							{/foreach}
						</table>
					</div>
					{/foreach}            
				</div>
				{/if}
				
				{if $tabs.description}
				<div class="tab tab-description textStyle {if $act_tab == 'description'}act{/if}">
					<article>{$product.description}</article>
				</div>
				{/if}
			
				{if $tabs.comments}
				<div class="tab tab-comments {if $act_tab == 'comments'}act{/if}">
					<script type="text/javascript">
						$(function() {
							if (location.hash=='#comments') {
								$('.product .tabs .tab').removeClass('act');
								$('.product .tabs .tabList [data-href=".tab-comments"]').click();
							}
						});
					</script>
					{moduleinsert name="\Comments\Controller\Block\Comments" type="\Catalog\Model\CommentType\Product"}            
				</div>
				{/if}
			</div>
		{/if}
    </div>    
    <div class="productImages">
        <div class="main">
            {$images=$product->getImages()}
            {if !$product->hasImage()}
                <span class="item"><img src="{$product->getMainImage()->getUrl(350,486,'xy')}"></span>
            {else}                
                {foreach $images as $key => $image}
                    <a href="{$image->getUrl(800,600,'xy')}" class="item {if $product->getMainDir()->name == 'Кулеры' || $product->getMainDir()->name == 'Пурифайеры'}zoom{/if}{if !$image@first} hidden{/if}" data-n="{$key}" target="_blank" data-zoom-src="{$image->getUrl(947, 1300)}"><img class="winImage" src="{$image->getUrl(350,486,'xy')}" alt="{$image.title|default:"{$product.title} фото {$key+1}"}"></a>
                {/foreach}
            {/if}
        </div>
        {if count($images)>1}
        <div class="gallery">
            <div class="wrap">
                <ul>
                    {foreach $images as $key => $image}
                    <li {if $image@first}class="first"{/if}><a href="{$image->getUrl(800,600,'xy')}" class="preview" data-n="{$key}" target="_blank"><img src="{$image->getUrl(70, 92)}"></a></li>
                    {/foreach}
                </ul>
            </div>
            <a class="control prev"></a>
            <a class="control next"></a>
        </div>
        {/if}
        
        <!--<ul class="articles">
            <li class="payment first">
                <span class="title" onclick="$(this).parent().toggleClass('open'); return false;">Условия оплаты <i class="flag"></i></span>
                <article class="text">
                    {moduleinsert name="\Main\Controller\Block\UserHtml" html="<p>&nbsp;Мы принимаем пластиковые карты Visa, Mastercard. А также любые электронные платежи Яндекс.Деньги, WebMoney, RBC Money, и.т.д</p>
<p>Вы можете расплатиться также со счета Вашего мобильного телефона. Прием платежей осуществляется с помощью сервисов Robokassa, Assist, PayPal, Яндекс.Деньги</p>"}
                </article>
            </li>
            <li class="delivery">
                <span class="title" onclick="$(this).parent().toggleClass('open'); return false;">Доставка <i class="flag"></i></span>
                <article class="text">
                    {moduleinsert name="\Main\Controller\Block\UserHtml" html="<p>Доставка товаров по территории России осуществляется бесплатно. Забрать товар самостоятельно можно из пункта самовывоза по адресу: ул. Краснодар, ул. Тестовая, 180. тел. 8 (918) 000-00-00</p>
<p>Стоимость доставки курьерскими службами за пределы России осуществляется в менеджером после оформления заказа. Менеджер свяжется с вами для уточнения стоимости доставки.</p>"}
                </article>
            </li>
        </ul>-->
    </div>    
    
    <div class="clearBoth"></div> 
		{moduleinsert name="\Catalog\Controller\Block\Recommended" indexTemplate="theme:akvatoriya/moduleview/catalog/blocks/recommended/recommended.tpl"}
</div>