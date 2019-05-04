{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
	{* Хлебные крошки *}
    {moduleinsert name="\Main\Controller\Block\BreadCrumbs"}
	
<h1>Доставка</h1>
<div class="mainContent" style="padding-top: 40px;">

	<div class="priem-zakazov">
		<img class="dostavka-img" src="{$THEME_IMG}/delivery-img1.png">
		<p class="dostavka-title">Принимаем заказы</p>
		<p class="dostavka-text">круглосуточно (с 8:00 до 20:00 принимает оператор, в другое время запись на автоответчик)</p>
	</div> 
	<div class="dostavka">
		<img class="dostavka-img" src="{$THEME_IMG}/delivery-img2.png">
		<p class="dostavka-title">Доставка</p>
		<p class="dostavka-text">преимущественно в день заказа, без выходных</p>
	</div>
	<div class="raschet">
		<img class="dostavka-img" src="{$THEME_IMG}/delivery-img3.png">
		<p class="dostavka-title">Мы работаем</p>
		<p class="dostavka-text">с физическими и юридическими лицами (по наличному и безналичном расчету)</p>
	</div>
<div class="block-text" style="margin-top: 70px;">
	<div class="w50ib" style="padding: 0 !important;">		
		<img src="{$THEME_IMG}/delivery-img4.jpg" style="float: left;">		
		<div style="float: left; width: 50%; box-sizing: border-box; padding-left: 15px; padding-top: 10px;">
			<p>Воду 19 л и кулеры мы доставляем бесплатно.</p>
			<p class="p__blue-bg">При заказе воды только в мелкой таре:</p>
			<p>• на сумму менее 250 руб. - доставка 100 руб.<br>
			• на сумму более 250 руб. - доставка бесплатно.<br>
			• при отгрузке вместе с водой 19л. - доставка бесплатно</p>
		</div>
		<div class="cb"></div>
	</div>
	<div class="w50ib" style="padding: 0 !important;">
		<div style="padding-left: 80px; box-sizing: border-box;"> 
			<img src="{$THEME_IMG}/delivery-img5.jpg" style="float: left; margin-right: 25px;">
			<div style="float: left; width: 50%; box-sizing: border-box; padding-left: 15px; padding-top: 10px; font-size: 1.8rem;">
				<div style="margin-bottom: 30px;"> 
					<img src="{$THEME_IMG}/orange-sq.jpg" style="float: left; margin-right: 10px;">
					<p>с 9:00 до 13:00</p>
				</div>
				<div class="cb"></div>
				<div style="margin-bottom: 30px;">
					<img src="{$THEME_IMG}/yelow-sq.jpg" style="float: left; margin-right: 10px;">
					<p>с 14:00 до 17:00</p>
				</div>
				<div class="cb"></div>
				<div>
					<img src="{$THEME_IMG}/green-sq.jpg" style="float: left; margin-right: 10px;">
					<p>с 18:00 до 21:00</p>
				</div>
				<div class="cb"></div>
			</div>
			<div class="cb"></div>
		</div>
		<div style="padding-left: 40px; box-sizing: border-box; margin-top: 30px;">
			<p>Чтобы вам было удобно, мы разбили время доставки на три отрезка.<br>
			Вы можете выбрать наиболее подходящий период, чтобы получить заказ.</p>
		</div>
	</div>
</div>
</div>	
	
{/block}