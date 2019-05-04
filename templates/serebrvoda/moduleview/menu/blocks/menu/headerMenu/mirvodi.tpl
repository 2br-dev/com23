{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
	{* Хлебные крошки *}
    {moduleinsert name="\Main\Controller\Block\BreadCrumbs"}
	
	<h1>Сеть магазинов «МИР ВОДЫ»</h1>
	<div class="block-text" id="mirvodi-block1">
		<img src="{$THEME_IMG}/mirvodi/img1.jpg" style="float: left; margin-right: 35px;"/>
		<p style="width: 70%;">В магазинах сети “Мир воды” представлена выставка-продажа оборудования (кулеры, помпы, фильтры для воды) и пункт обмена питьевой воды.</br>
		Для удобства покупателей эти магазины расположены в разных районах города.  
		</p>		
		<div class="cb"></div>
		<div class="address-link">
			<a href="#mirvodi-krasnodar" style="color: #27379c; font-family: Tahoma, Arial; text-transform: uppercase; display: block; font-size: 16px;">Адреса магазинов в г. Краснодар</a>
			<a href="#mirvodi-anapa" style="color: #27379c; font-family: Tahoma, Arial; text-transform: uppercase; padding-top: 15px; display: block; font-size: 16px;">Адреса магазинов в г. Анапа</a>
		</div>
	</div>
		
	<div class="block-text blue-bg" id="mirvodi-block2">
		<p style="padding: 20px 20px 0px 20px; color: #ffffff;">Мы не просто продаем воду и оборудование – мы открываем для вас целый мир питьевой воды.</br></br>
		Среди представленной на полках магазинов продукции – предельно чистая, прошедшая тщательную фильтрацию вода из родников, минеральных источников, ледников Кавказа. Она не только безопасна и безвредна для организма – она в сотни раз полезнее той жидкости, которая течет из крана.</p>
	</div>
	
	<div style="text-align: center; margin-top: 40px;"><img style="max-width: 100%;" src="{$THEME_IMG}/mirvodi/img2.jpg" /></div>
	
	<div class="block-text" id="mirvodi-block3">		
		<p>Во всех магазинах «Мир воды» представлено не менее 40 моделей кулеров, помпы и питьевая вода, фильтры для воды: кувшинного типа, под мойку, обратноосмостические.</p>
		<p>Вы можете выбрать понравившийся Вам раздатчик питьевой воды, заказать его доставку, а также купить питьевую воду в 19 литровых бутылях.</p>
		<p>Наши продавцы дадут Вам квалифицированную консультацию по всем возникающим вопросам, связанным с выбором питьевой воды и оборудования для её розлива и очистки.</p>
	</div>
	
	<h1 id="mirvodi-krasnodar">Магазины «МИР ВОДЫ» в Краснодаре</h1>
	<div class="block-text" id="mirvodi-block4">		
		<div class="krasnodarShop__item">
			<img src="{$THEME_IMG}/mirvodi/krasnodar/mag1.jpg"/>
			<div class="address-shop-block">
				<p class="address-shop">ул. Ростовское шоссе, дом № 14</p>
				<p class="regim-shop-title">Время работы:</p>
				<p class="regim-shop">Ежедневно с 8-00 до 20-00</br>
			    Перерыв с 13-00 до 14-00
				</p>
			</div>
		</div>
		<div class="krasnodarShop__item">
			<img src="{$THEME_IMG}/mirvodi/krasnodar/mag2.jpg"/>
			<div class="address-shop-block">
				<p class="address-shop">ул. Красных Партизан, дом № 123</p>
				<p class="regim-shop-title">Время работы:</p>
				<p class="regim-shop">Ежедневно с 8-00 до 20-00</br>
				   Перерыв с 13-00 до 14-00
				</p>
			</div>
		</div>
		<div class="krasnodarShop__item">
			<img src="{$THEME_IMG}/mirvodi/krasnodar/mag3.jpg"/>
			<div class="address-shop-block">
				<p class="address-shop">ул. Уральская, дом № 144</p>
				<p class="regim-shop-title">Время работы:</p>
				<p class="regim-shop">Понедельник-пятница: с 9-00 до 19-00</br>
					Суббота:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;с 9-00 до 16-00</br>
					Воскресенье:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; выходной</br>
				   Перерыв:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; с 13-00 до 14-00
				</p>
			</div>
		</div>
		<div class="krasnodarShop__item">
			<img src="{$THEME_IMG}/mirvodi/krasnodar/mag5.jpg"/>
			<div class="address-shop-block">
				<p class="address-shop">ул. Буденного, дом № 73</p>
				<p class="regim-shop-title">Время работы:</p>
				<p class="regim-shop">Ежедневно с 8-00 до 20-00</br>
				   Перерыв с 13-00 до 14-00						   
				</p>
			</div>
		</div>
		<div class="krasnodarShop__item">
			<img src="{$THEME_IMG}/mirvodi/krasnodar/mag6.jpg"/>
			<div class="address-shop-block">
				<p class="address-shop" style="margin-bottom: 30px;">Тургеневское шоссе, 27, ТЦ "Мега Адыгея"</p>
				<p class="address-shop">(Вход со стороны АШАНА)</p>
			</div>
		</div>
		<div class="krasnodarShop__item">
			<img src="{$THEME_IMG}/mirvodi/krasnodar/mag7.jpg"/>
			<div class="address-shop-block">
				<p class="address-shop">ул. Алма-Атинская, 151</p>
				<p class="regim-shop-title">Время работы:</p>
				<p class="regim-shop">Понедельник-пятница: с 9-00 до 19-00</br>
					Суббота:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;с 9-00 до 16-00</br>
					Воскресенье:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; выходной
				</p>
			</div>	
		</div>
	</div>
	
	<h1 id="mirvodi-anapa">Магазины «МИР ВОДЫ» в Анапе</h1>
	<div class="block-text" id="mirvodi-block5">
		<img src="{$THEME_IMG}/mirvodi/anapa/mag1.jpg" style="float: left; margin-right: 40px;"/>
		<div style="float: left; padding-left: 10px;">
			<p class="address-shop" style="margin-bottom: 20px !important;">г. Анапа, ул. Лермонтова, д. № 115</p>
			<p class="regim-shop-title" >Время работы:</p>
			<p class="regim-shop" style="margin-bottom: 25px !important;">Ежедневно с 8-00 до 20-00</br>
			   Перерыв с 13-00 до 14-00
			</p>
			<p class="regim-shop-title">Телефоны:</p>
			<p class="regim-shop">8-918-33-33-222 </br>
				8-86133-24-333 </br>
				(в ночное время ваш заказ примет автоответчик)
			</p>
			
		</div>
		<div class="cb"></div>
	</div>
	<p style="font-family: Tahoma, Arial; color: #002095; font-size: 16px; text-align: center;">Мы рады видеть Вас в числе наших покупателей!</p>
{/block}