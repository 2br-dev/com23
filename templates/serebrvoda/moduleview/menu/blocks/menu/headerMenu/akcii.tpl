{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
	{* Хлебные крошки *}
    {moduleinsert name="\Main\Controller\Block\BreadCrumbs"}
	
<h1>Акции</h1>
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
		<p style="font-family: Tahoma, Arial; color: #000000; font-size: 14px;">Компания "Единая служба доставки воды" всегда стремится идти навстречу своим клиентам и радовать их приятными сюрпризами и интересными акциями. Участвуя в них, Вы можете приобрести нужные Вам товары со значительной скидкой или даже получить их бесплатно.<br>
		<br>Для того, чтобы быть в курсе всех наших новых акций следите регулярно за обновлениями раздела. Мы всегда рады Вам!</p>
	</div>
	<div class="cb"></div>
	
	<div class="block-text">
		<table>
			<tr>
				<td width="500px" style="text-align: center;">
										
				</td>
				<td width="500px" style="text-align: center;">
										
				</td>
			</tr>
		</table>
	</div>
		
{/block}