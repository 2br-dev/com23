{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
	{* Хлебные крошки *}
    {moduleinsert name="\Main\Controller\Block\BreadCrumbs"}
	
<h1>Галерея</h1>
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
	
	<div style="float: left; width: 800px;">
		<p style="font-family: Tahoma, Arial; color: #000000; font-size: 14px;">Компания "Единая служба доставки питьевой воды" регулярно участвует в разнообразных акциях и праздниках. С наступлением тепла мы часто выходим на улицы Краснодара и неустанно угощаем горожан вкусной питьевой водой.<br><br>
		В этом разделе Вы найдете фотоотчеты с различных мероприятий, в которых мы принимали участие, а также наши видеоролики.</p>
	</div>
	<div class="cb"></div>
	
	<div class="block-text">
		<table>
			<tr style="padding-bottom: 15px;">
				<td width="500px" style="text-align: center; padding-bottom: 15px;">
					<a href="/o-kompanii/galereya/albom1/"><img src="{$THEME_IMG}/galereya/album1/oblogka-album1.jpg" style="margin-bottom: 15px;"/></a>
					<div class="title-album" style="text-align: left;"><a href="/o-kompanii/galereya/albom1/" class="a-album-title">XXI Открытый фестиваль кино стран СНГ, Латвии, Литвы и Эстонии Киношок-2012</a></div>
				</td>
				<td width="500px" style="text-align: center; padding-bottom: 15px;">
					<a href="/o-kompanii/galereya/albom2/"><img src="{$THEME_IMG}/galereya/album2/oblogka-album2.jpg"/ style="margin-bottom: 15px;"></a>
					<div class="title-album" style="text-align: left;"><a href="/o-kompanii/galereya/albom2/" class="a-album-title">Велопробег в Краснодаре по случаю празднования Дня флага России</a></div>
				</td>
			</tr>
			<tr>
				<td width="500px" style="text-align: center; padding-bottom: 15px;">
					<a href="/o-kompanii/galereya/albom3/"><img src="{$THEME_IMG}/galereya/album3/oblogka-album3.jpg" style="margin-bottom: 15px;"/></a>
					<div class="title-album" style="text-align: left;"><a href="/o-kompanii/galereya/albom3/" class="a-album-title">Празднование Дня России в 2013 году</a></div>
				</td>
				<td width="500px" style="text-align: center; padding-bottom: 15px;">
					<a href="/o-kompanii/galereya/albom4/"><img src="{$THEME_IMG}/galereya/album4/oblogka-album4.jpg"/ style="margin-bottom: 15px;"></a>
					<div class="title-album" style="text-align: left;"><a href="/o-kompanii/galereya/albom4/" class="a-album-title">День города 2013</a></div>
				</td>
			</tr>
			<tr>
				<td width="500px" style="text-align: center; padding-bottom: 15px;">
					<a href="/o-kompanii/galereya/albom5/"><img src="{$THEME_IMG}/galereya/album5/oblogka-album5.JPG" style="margin-bottom: 15px;"/></a>
					<div class="title-album" style="text-align: left;"><a href="/o-kompanii/galereya/albom5/" class="a-album-title">День города 2014</a></div>
				</td>
				<td width="500px" style="text-align: center; padding-bottom: 15px;">
					
				</td>
			</tr>
		</table>
	</div>
	
	<div class="block-text blue-bg">
		<h2 style="color: #ffffff; padding-top: 20px;">Видео ролики</h2>
	</div>
		
{/block}