<div class="bodyWrap">
<div class="md_overlay" id="md_overlay"></div>
    <header>
        <div class="viewport">           
            {* Логотип *}
            {moduleinsert name="\Main\Controller\Block\Logo" width="143" height="86"}		
			
			<div class="header-menu">
				{moduleinsert name="\Menu\Controller\Block\Menu" indexTemplate="blocks/menu/foot_menu.tpl" root="bottom"}
			</div>
			
			<div class="recall">
				{* Кнопка презвоните мне *}
				{moduleinsert name="\Feedback\Controller\Block\Button" indexTemplate='theme:akvatoriya/moduleview/feedback/blocks/recall/recall.tpl' form_id='2'}
			</div>
			
            <div class="userBlock">
                {if ModuleManager::staticModuleExists('shop')}
                    {* Блок авторизации *}
                    {moduleinsert name="\Users\Controller\Block\AuthBlock"}
                {/if}                          
            </div>
			
			
				<div class="krasnodarContacts">
					<p class="krasnodarContacts__title">Краснодар</p>
					<p class="krasnodarContacts__phone1">20-444-44</p>
					<!--<p style="font-size: 14px; font-weight: bold;  margin-bottom: 3px;">(861) 259-55-59</p>-->
					<p class="krasnodarContacts__phone2">8(988) 333-444-3</p>
				</div>				
			<div class="searchBlock">
				{* Поисковая строка 
                {moduleinsert name="\Catalog\Controller\Block\SearchLine"} *}
                <div class="mobile-application">
                	<p class="mobile-application__title">Заказать через приложения:</p>
                	<div class="watsapp">
                		<a href="whatsapp://send?phone=+79898200188">+7-989-8200-188</a>
                	</div>
                	<div class="google">
                		<a href="https://play.google.com/store/apps/details?id=com.voda.ru.com23"><img src="{$THEME_IMG}/play-link.jpg" width="100"></a>
                	</div>
                	<div class="apple">
                		<a href="https://itunes.apple.com/us/app/readyscript/id1351231029"><img src="{$THEME_IMG}/app-link.jpg" width="100"></a>
                	</div>
                </div> 
			</div>
			<div class="anapaContacts">
				<p class="anapaContacts__title">Анапа</p>
				<p class="anapaContacts__phone1">8(918) 33-33-222</p>
				<p class="anapaContacts__phone2">8-86133-24-333</p>
			</div>
        </div>
    </header>    
    <div class="viewport">
        {* Список категорий товаров *}
        {moduleinsert name="\Catalog\Controller\Block\Category"}
    </div>      
    <div class="viewport {if $smarty.server.REQUEST_URI != '/'}mainContent {/if}">    
        {* Данный блок будет переопределен у наследников данного шаблона *}
        {block name="content"}{/block}        
    </div>
	<footer>
        <div class="footzone">
			<div class="headerContacts">
				<div class="krasnodarContacts">
					<p class="krasnodarContacts__title">Краснодар</p>
					<p class="krasnodarContacts__phone1">(861) 253-54-53</p>
					<p class="krasnodarContacts__phone2">(988) 333-444-3</p>
				</div>
				<div class="anapaContacts">
					<p class="anapaContacts__title">Анапа</p>
					<p class="anapaContacts__phone1">8(918) 33-33-222</p>
					<p class="anapaContacts__phone2">8-86133-24-333</p>
				</div>
			</div>
			<div class="user-agreement">
				<p>Авторские права на информационные материалы (в том числе, но неограничиваясь перечисленным: изображения, фотографии, тексты, логотипы, дизайнотдельных блоков Сайта и всего Сайта в целом), размещенные на Сайте,принадлежат Владельцу Сайта (ООО «Акватория») и иным правообладателям, ссогласия которых материалы были размещены на Сайте. Иные лица не вправе каким-либо образом использовать размещенные на Сайте материалы, копировать полностью или частично, распространять, видоизменять, воспроизводить указанныематериалы без предварительного разрешения Владельца Сайта и (или) иных правообладателей. Все права на информационные материалы, в том числе на изображения (фотографии), размещенные на Сайте, охраняются в соответствии с национальным и международным законодательством (Глава 70 Гражданского кодексаРФ, Всемирная конвенция об авторском праве, Бернская конвенция об охране литературных и художественных произведений и иные нормативные акты в области охраны авторских прав). При использовании любых информационных материалов иизображений (фотографий) с Сайта в сети Интернет обязательным условием является указание на источник материалов - Сайт, а также активная гиперссылка на Сайт в виде: www.com23.ru.</p>
			</div>
			{* Логотип *}
			<div class="footer-logo">
				{moduleinsert name="\Main\Controller\Block\Logo" width="71" height="43"}
			</div>
			<div class="footer-slogan">
				<p style="color: #ffffff;">Единая служба доставки питьевой воды - Доставка воды в Краснодаре и Анапе.</p>
			</div>
			<div class="cb"></div>
			<p class="footer-copyright">© Все права защищены</p>
			<p class="footer-oferta">Содержимое сайта не является публичной офертой</p>
			
			{if $CONFIG.facebook_group || $CONFIG.vkontakte_group || $CONFIG.twitter_group}
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
            {/if}
			
			<!--<div class="menu-footer">
				<ul>
					<li><a class="dlydilerov-menu menu-footer-item" href="/text-news/"><span>Новости</span></a></li>
					<li><a class="vakansii-menu menu-footer-item" href="/o-kompanii/akcii/"><span>Акции</span></a></li>										
				</ul>
			</div>-->
		</div>        
    </footer>
    
    {block name="fixedCart"}  {* Разрешаем перезаписывать данный блок у наследников *}
    <div class="fixedCart">
        <div class="viewport">
            <a href="#" class="up" id="up" title="наверх"></a>
            {* Кнопка обратная связь *}
            {moduleinsert name="\Feedback\Controller\Block\Button" form_id="1"}
            
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