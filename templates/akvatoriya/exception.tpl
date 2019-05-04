<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Ой, ошибочка {$error.code}</title>
<!--[if lt IE 9]>
<script src="{$THEME_JS}/html5shiv.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="{$THEME_CSS}/reset.css">
<link rel="stylesheet" type="text/css" href="{$THEME_CSS}/style.css">

</head>
<body class="exceptionBody">
<div class="bodyWrap">
    <header>
        <div class="viewport">           
            {* Логотип *}
            {moduleinsert name="\Main\Controller\Block\Logo" width="143" height="86"}
            
			<div class="searchBlock">
				{* Поисковая строка *}
                {moduleinsert name="\Catalog\Controller\Block\SearchLine"} 
			</div>
			
			<div class="header-menu">
				{moduleinsert name="\Menu\Controller\Block\Menu" indexTemplate="blocks/menu/foot_menu.tpl" root="bottom"}
			</div>
			
            <div class="userBlock">
                {if ModuleManager::staticModuleExists('shop')}
                    {* Блок авторизации *}
                    {moduleinsert name="\Users\Controller\Block\AuthBlock"}
                {/if}                          
            </div>
			{if $CONFIG.facebook_group || $CONFIG.vkontakte_group || $CONFIG.twitter_group}
            <div class="social">
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
			<div class="headerContacts">
				<div class="krasnodarContacts">
					<p style="font-size: 14px; margin-bottom: 5px;">Краснодар</p>
					<p style="font-size: 20px; font-weight: bold; margin-bottom: 3px;">(861) 253-54-53</p>
					<p style="font-size: 20px; font-weight: bold;">(861) 259-55-59</p>
				</div>
				<div class="anapaContacts">
					<p style="font-size: 14px; margin-bottom: 8px;">Анапа</p>
					<p style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">8(918) 33-33-222</p>
					<p style="font-size: 14px; font-weight: bold;">8-86133-24-333</p>
				</div>
			</div>
        </div>
	</header>
    <div class="viewport mainContent">
        {* Список категорий товаров *}
        {moduleinsert name="\Catalog\Controller\Block\Category"}        
        <div class="exception">
            <div class="code">
                <div class="number">{$error.code}</div>
                <div class="text">Страница не найдена</div>
            </div>
            <div class="message">{$error.comment}
            <br>
            <br>
            <a href="{$site->getRootUrl()}">Перейти на главную</a>
            </div>
            <div class="clearBoth"></div>                    
        </div>        
    </div>
	<footer>
        <div class="footzone"></div>
    </footer>
</div> <!-- .bodyWrap -->


</html>