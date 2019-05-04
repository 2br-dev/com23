<!--<div class="bodyWrap checkout">
    <header>
        <div class="viewport">
            {* Логотип *}
            {moduleinsert name="\Main\Controller\Block\Logo" width="200" height="75"}
            
            {* Корзина *}
            {moduleinsert name="\Shop\Controller\Block\Cart" indexTemplate="blocks/cart/co_cart.tpl"}
            
            {* Шаги оформления заказа *}
            {moduleinsert name="\Shop\Controller\Block\CheckoutStep"}               
        </div>
    </header>-->
<div class="bodyWrap checkout">
<div class="md_overlay" id="md_overlay"></div>
	<header>
        <div class="mainContent">           
            {* Логотип *}
            {moduleinsert name="\Main\Controller\Block\Logo" width="196" height="79"}

            <div class="header__company-info">
            	<div class="header__regim">
            		<p>приём заказов<br>круглосуточно</p>
            		<p>работаем без<br>выходных</p>
            	</div>
            	<div class="header__phone">
            		<p>8 (8617) 211-731</p>
            		<p>8-988-769-77-44</p>
            	</div>
            </div>

            <div class="header-menu">
				{moduleinsert name="\Menu\Controller\Block\Menu" indexTemplate="blocks/menu/foot_menu.tpl" root="bottom"}
			</div>

			{* Шаги оформления заказа *}
            {moduleinsert name="\Shop\Controller\Block\CheckoutStep"}
			
			{* Корзина *}
            {moduleinsert name="\Shop\Controller\Block\Cart" indexTemplate="blocks/cart/co_cart.tpl"}		
			
        </div>
    </header>    

    <div class="viewport mainContent">
		{* Список категорий товаров *}
        {moduleinsert name="\Catalog\Controller\Block\Category"}
		
        {* Главное содержимое страницы *}
        {$app->blocks->getMainContent()}        
    </div>
</div>
	<footer>
        <div class="footzone" style="padding-bottom: 0px;">			
			{* Логотип *}
			<div class="footer-logo">
				<img src="{$THEME_IMG}/logo-footer.png">
			</div>
			<div class="footer-text slogan">
				<p>Продажа и доставка питьевой воды 19 л, 5 л, 1,5 л, 1 л на дом и в офис в Новороссийске.</p>
				<p>Продажа и доставка оборудования для розлива воды. Кулеры, помпы.</p>
				<p>Ремонт и санитарное обслуживание кулеров.</p>
			</div>
			<div class="footer-text copyright">
				<img src="{$THEME_IMG}/slon-logo.png" style="margin-bottom: 10px;">
				<p>© 2016 Все права защищены. "Серебряная"</p>
			</div>
			<div class="cb"></div>

			{* {if $CONFIG.facebook_group || $CONFIG.vkontakte_group || $CONFIG.twitter_group}
            <div class="social">
            	<a href="https://www.instagram.com/akvatoriya23/" class="instgram"></a>
                {if $CONFIG.facebook_group}
                <a href="{$CONFIG.facebook_group}" class="facebook"></a>
                {/if}
                {if $CONFIG.vkontakte_group}
                <a href="{$CONFIG.vkontakte_group}" class="vk"></a>
                {/if}
                {if $CONFIG.twitter_group}
                <a href="{$CONFIG.twitter_group}" class="twitter"></a>
                {/if}
				<a href="http://www.odnoklassniki.ru/yedinay" class="odnokl"></a>

            </div>
            {/if} *}
			
			<div class="menu-footer">
				<ul>
					<li><a class="menu-footer-item" href="/text-news/"><span>Вода</span></a></li>
					<li><a class="menu-footer-item" href="/o-kompanii/akcii/"><span>Кулеры</span></a></li>
					<li><a class="menu-footer-item" href="/o-kompanii/akcii/"><span>Помпы</span></a></li>
					<li><a class="menu-footer-item" href="/o-kompanii/akcii/"><span>Сопутствующие товары</span></a></li>							
				</ul>
			</div>
			<div class="footer-contacts">
				<div class="footer-contacs__address">
					<p>г. Новроссийск,<br>ул. Луначарского, 28 Д</p>
					<p class="footer-email">E-mail: slon.voda@yandex.ru</p>
				</div>
				<div class="footer-contacts__phones">
					<p>8 (8617) 211-731</p>
					<p>8 (8617) 211-783</p>
					<p>8 (988) 769-77-44</p>
					<p>8 (988) 765-77-44</p>
				</div>
			</div>
		</div>        
    </footer>
