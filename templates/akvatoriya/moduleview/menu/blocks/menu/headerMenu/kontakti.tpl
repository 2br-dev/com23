{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
	{* Хлебные крошки *}
    {moduleinsert name="\Main\Controller\Block\BreadCrumbs"}
	
	<h1>Контакты</h1>
	<div class="block-text border-dot">		
		<p style="padding: 10px 100px;">Заказать воду, а также другую продукцию и услуги компании Вы можете любым удобным для Вас способом:
		</p>		
	</div>
	<div class="block-text">
		<table>
			<tr>
				<td width="34%" style="text-align: center;">
					<div class="blue-bg" style="padding: 10px 10px 5px 10px; margin-bottom: 30px;"><p style="color: #ffffff; font-size: 16px;">- через диспетчерскую службу по телефону </br><span style="font-weight: bold; line-height: 30px;">КРУГЛОСУТОЧНО</span></p></div>
					<img = src="{$THEME_IMG}/kontakti/img1.jpg" />
				</td>
				<td width="33%" style="padding: 0 0 0 40px;">
					<p style="font-size: 14px;"><span style="color: #002095; font-weight: bold;">- в Краснодаре:</span> c 8-00 до 20-00 без перерыва и выходных ваш заказ примет менеджер, в остальное время вы можете оставить заказ на автоответчике.</p>
					<p style="color: #002095; width: 100%; text-align: left; font-size: 36px;">(861) 253-54-53</p>
					<div style= "float: left; margin-right: 40px; margin-top: 10px;">
						<p style="color: #002095;">8-988-333-444-3</p>
						<p style="color: #002095;">8-928-333-444-3</p>
						<p style="color: #002095;">(861) 259-55-59</p>
					</div>
					<div style="margin-top: 10px;">
						<p style="color: #002095;">8-988-246-76-66</p>
						<p style="color: #002095;">8-961-853-22-33</p>
						<p style="color: #002095;">8-903-411-03-06</p>
					</div>
				</td>
				<td width="33%" style="padding: 0 0 0 40px;">
					<p style="font-size: 14px;"><span style="color: #002095; font-weight: bold;">в Анапе:</span> c 9-00 до 20-00 без выходных ( в ночное время работает автоответчик )</p>
					<p style="color: #002095; width: 100%; text-align: center; font-size: 30px; margin-top: 20px;">(86133) 24-333</p>
					<p style="color: #002095; text-align: center;">8-918-33-33-222</p>
				</td>				
			</tr>
		</table>
	</div>
	
	<div class="block-text">	
		<table width="100%">
			<tr>
				<td width="34%" style="text-align: center;">
					<div class="blue-bg" style="padding: 10px 0px 10px 0px; margin-bottom: 30px; width: 100%; text-align: center;"><p style="color: #ffffff; font-size: 16px;">- через магазины "МИР ВОДЫ"</p></div>
					<img = src="{$THEME_IMG}/kontakti/img2.jpg" />
				</td>
				<td width="33%" style="padding: 0 0 0 30px;">
					<p style="margin-bottom: 15px;">В Краснодаре:</p>
					<p style="color: #002095; font-size: 14px;">ул. Ростовское шоссе, дом № 14</p>
					<p style="color: #002095; font-size: 14px;">ул. Красных Партизан, дом № 123</p>					
					<p style="color: #002095; font-size: 14px;">ул. Будённого, дом № 73</p>
					<p style="color: #002095; font-size: 14px;">ул. Уральская, дом № 144</p>

					<p style="color: #002095; font-size: 14px;">Тургеневское шоссе, 27, ТЦ "МЕГА-Адыгея"</p>

					<p style="margin-bottom: 15px;">В Анапе:</p>
					<p style="color: #002095; font-size: 14px;">ул. Лермонтова, дом № 115</p>
				</td>
				<td width="33%" style="text-align: center;">
					<div class="blue-bg" style="padding: 10px 0px 10px 0px; margin-bottom: 40px; width: 100%; text-align: center;"><p style="color: #ffffff; font-size: 16px;">- через интернет-магазин</br>(только в городах Краснодар и Анапа)</p></div>
					<img = src="{$THEME_IMG}/kontakti/img3.jpg" />
				</td>
			</tr>
		</table>
	</div>
{/block}