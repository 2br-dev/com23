<div class="bodyWrap">
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
			
			<div class="header__cart-box">			
	            <div class="userBlock">
	                {if ModuleManager::staticModuleExists('shop')}
	                    {* Блок авторизации *}
	                    {moduleinsert name="\Users\Controller\Block\AuthBlock"}
	                {/if}                          
	            </div>	
			</div>
        </div>
    </header>    
    <div class="viewport">
        {* Список категорий товаров *}
        {moduleinsert name="\Catalog\Controller\Block\Category"}
        
        {* Данный блок будет переопределен у наследников данного шаблона *}
        {block name="content"}{/block}        
    </div>
	<footer>
        <div class="footzone">			
			{* Логотип *}
			<div class="footer-logo">
				<img src="{$THEME_IMG}/logo-footer.png" alt="Логотип компании">
			</div>
			<div class="footer-text ishop">
				<!--<p>Доставка воды в Новороссийске</p>-->
			</div>
			<div class="footer-text slogan">
				<p>Продажа и доставка питьевой воды 19 л, 5 л, 1,5 л, 1 л на дом и в офис в Новороссийске.</p>
				<p>Продажа и доставка оборудования для розлива воды. Кулеры, помпы.</p>
				<p>Ремонт и санитарное обслуживание кулеров.</p>
			</div>
			<div class="footer-text copyright">
				<img src="{$THEME_IMG}/slon-logo.png" style="margin-bottom: 10px;" alt="Логотип компании Слон">
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
					<li><a class="menu-footer-item" href="http://серебрянаявода.рф/catalog/voda/"><span>Вода</span></a></li>
					<li><a class="menu-footer-item" href="http://серебрянаявода.рф/catalog/kulery/"><span>Кулеры</span></a></li>
					<li><a class="menu-footer-item" href="http://серебрянаявода.рф/catalog/pompy/"><span>Помпы</span></a></li>
					<li><a class="menu-footer-item" href="http://серебрянаявода.рф/catalog/soputstvuyushchie-tovary/"><span>Сопутствующие товары</span></a></li>							
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
    
    {block name="fixedCart"}  {* Разрешаем перезаписывать данный блок у наследников *}
    <div class="fixedCart">
        <div class="viewport mainContent">
            <a href="#" class="up" id="up" title="наверх"></a>
            {* Кнопка обратная связь 
            {moduleinsert name="\Feedback\Controller\Block\Button" form_id="1"}*}
            
            {if ModuleManager::staticModuleExists('shop')}
                {* Корзина *}
                {moduleinsert name="\Shop\Controller\Block\Cart"}
            {/if}
            
            {* Сравнить товары *}
            {moduleinsert name="\Catalog\Controller\Block\Compare" indexTemplate="blocks/compare/cart_compare.tpl"}
        </div>
    </div>
    {/block}

</div> <!-- .bodyWrap -->