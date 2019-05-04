{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
	{* Хлебные крошки *}
    {moduleinsert name="\Main\Controller\Block\BreadCrumbs"}
	
<h1>Наша команда</h1>
	<div class="menu-okompanii">
		<ul>
			<li><a class="news-menu menu-okompanii-item" href="/text-news/"><span>Новости</span></a></li>
			<li class="akcii-menu menu-okompanii-item"><a href="/o-kompanii/akcii/"><span>Акции</span></a></li>
			<li class="komanda-menu menu-okompanii-item"><a href="/o-kompanii/komanda/"><span>Команда</span></a></li>
			<li class="gallery-menu menu-okompanii-item"><a href="/o-kompanii/galereya/"><span>Галерея</span></a></li>
			<li class="nagradi-menu menu-okompanii-item"><a href="/o-kompanii/nagrady/"><span>Награды</span></a></li>
			<!--<li class="rekviz-menu menu-okompanii-item"><a href="/o-kompanii/rekvizity/"><span>Реквизиты</span></a></li>-->
		</ul>
	</div>
	
	<div style="float: left; width: 580px; margin-right: 30px;">
		<p style="font-family: Tahoma, Arial; color: #000000; font-size: 14px;">Залог успеха любого предприятия - в его сотрудниках. Именно благодаря дружной команде Единой службы доставки питьевой воды наша компания динамично развивается и расширяется.<br><br>
		Слаженная и хорошо организованная работа коллектива свидетельствует не только о высокой квалификации работников, но и о взаимопонимании и тесном сотрудничестве. Благоприятная атмосфера на рабочих местах и достойная заработная плата способствуют тому, что год за годом наши показатели неуклонно растут, а штат сотрудников - расширяется.<br><br>
		Если вы хотите работать с нами и стать частью нешей команды, пожалуйста, ознакомьтесь с вакансиями.</p>
	</div>
	<div class="rabotnik-goda" style="float: left; width: 230px; text-align: center;">
		<p style="font-family: Arial; font-size: 14px; color: #012095; text-transform: uppercase; margin-bottom: 15px;">Лучший работник 2014 года</p>
		<img src="{$THEME_IMG}/komanda/rabotnik-goda.jpg"/>
		<p style="font-family: Arial; font-size: 14px; color: #012095; text-transform: uppercase; margin-top: 15px;">Елена Вивчарь,</p>
		<p style="font-family: Arial; font-size: 12px; color: #012095; text-transform: lowercase; margin-top: 5px;">менеджер</p>
	</div>
	<div class="cb"></div>
	
	<div class="block-text">
		<h2 style="font-weight: bold;">Работа у нас - это:</h2>
		<div class="rabota">
			<div style="width: 25%; float: left; background: url({$THEME_IMG}/komanda/rabota-bg.png) no-repeat center; height: 80px; padding-top: 30px;">
				<p style="font-family: Arial; font-size: 14px; color: #012095; font-weight: bold; text-transform: uppercase; float: left; line-height: 24px; margin-right: 10px; padding-left: 30px;">Стабильность и</br>уверенность</p><img style="padding-top: 5px;" src="{$THEME_IMG}/komanda/stabilnost.png"/>
			</div>
			<div style="width: 25%; float: left; background: url({$THEME_IMG}/komanda/rabota-bg.png) no-repeat center; height: 80px; padding-top: 30px;">
				<p style="font-family: Arial; font-size: 14px; color: #012095; font-weight: bold; text-transform: uppercase; float: left; line-height: 24px; margin-right: 10px; padding-left: 30px;">Обучение и</br>карьерный рост</p><img style="padding-top: 5px;" src="{$THEME_IMG}/komanda/obuchenie.png"/>
			</div>	
			<div style="width: 25%; float: left; background: url({$THEME_IMG}/komanda/rabota-bg.png) no-repeat center; height: 80px; padding-top: 30px;">
				<p style="font-family: Arial; font-size: 14px; color: #012095; font-weight: bold; text-transform: uppercase; float: left; line-height: 24px; margin-right: 20px; padding-left: 30px;">Достойная</br>оплата труда</p><img style="padding-top: 5px;" src="{$THEME_IMG}/komanda/oplata.png"/>
			</div>	
			<div style="width: 25%; float: left; background: url({$THEME_IMG}/komanda/rabota-bg.png) no-repeat center; height: 80px; padding-top: 30px;">
				<p style="font-family: Arial; font-size: 14px; color: #012095; font-weight: bold; text-transform: uppercase; float: left; line-height: 24px; margin-right: 40px; padding-left: 30px;">Дружный</br>коллектив</p><img src="{$THEME_IMG}/komanda/kolectiv.png"/>
			</div>			
			<div class="cb"></div>
		</div>
	</div>
	
	<div class="block-text">
		<img src="{$THEME_IMG}/komanda/komanda.jpg"/>
		<a style="float: right;">перейти в галерею наших сотрудников</a>
	</div>
	
	<div class="block-text">
		<div class="border-dot" style="width: 330px; margin: 0 auto;">
			<h2>Наши вакансии</h2>
		</div>
	</div>
		
{/block}