{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
	{* Хлебные крошки *}
    {moduleinsert name="\Main\Controller\Block\BreadCrumbs"}
	
	<h1>Условия доставки и оплаты товаров</h1>
	
	<div class="block-text">
		<div class="dostavka__block1">
		
			<div class="blue-bg" style="padding: 20px 50px;  margin-bottom: 50px;">
				<img src="{$THEME_IMG}/dostavka/1.png" style="float: left; margin-right: 15px;"/>
				<p style="font-family: Tahoma; color: #ffffff; font-size: 14px;">Мы осуществляем доставку питьевой воды и оборудования для розлива <span style="text-transform: uppercase; font-weight: bold;">без выходных и праздников</span> 364 дня в году кроме 1 января.</p>
				<div class="cb"></div>
			</div>
			
			<div class="blue-bg" style="padding: 20px 50px; margin-bottom: 50px;">
				<img src="{$THEME_IMG}/dostavka/2.png" style="float: left; margin-right: 15px;"/>
				<p style="font-family: Tahoma; color: #ffffff; font-size: 14px;">Доставка воды по городу осуществляется <span style="text-transform: uppercase; font-weight: bold;">бесплатно!</span></br> 
				Условия доставки в <a href="#otdalennie" style="font-family: Tahoma; color: #ffffff; font-size: 14px;">отдаленные районы*</a> уточняйте у оператора.</p>
				<div class="cb"></div>
			</div>
			
			<div style="margin-bottom: 50px;">
				<img src="{$THEME_IMG}/dostavka/3.jpg"/ style="float: left; margin-left: 30px;">
				<h2>Прием заказов на доставку воды и оборудования:</h2>
				<p style="font-family: Tahoma; color: #000000; font-size: 14px; padding-left: 200px; margin-bottom: 20px">• по телефону — круглосуточно;</p>
				<p style="font-family: Tahoma; color: #000000; font-size: 14px; padding-left: 200px;">• через сайт — круглосуточно;</p>
				<div class="cb"></div>
			</div>
			
			<div>
				<table style="margin-bottom: 20px;">
					<tr>
						<td style="padding: 0 30px;">
							<p style="font-family: Tahoma; color: #012095; font-size: 14px;"><strong>Ежедневно без праздничных и выходных дней с 8-00 до 20-00</strong> наши специалисты готовы принять у Вас заявку и ответить на все Ваши вопросы.</p>
						</td>
						<td style="padding: 0 30px;"><p style="font-family: Tahoma; color: #012095; font-size: 14px;"><strong>С 20-00 до 8-00</strong> заявку можно оставить на автоответчик (для подтверждения заказа с Вами свяжется менеджер в рабочее время).</p></td>
					</tr>
				</table>
			</div>
			
		</div>
		
		<div style="float: left; width: 320px; padding-left: 20px;">
			<img src="{$THEME_IMG}/dostavka/4.jpg"/ style="margin-left: 15px; margin-bottom: 20px;">
			<h2 style="text-align: left;">Доставка воды</br>осуществляется ежедневно:</h2>
			
			<p style="font-family: Tahoma; color: #000000; font-size: 14px; font-weight: bold;">В будние дни три периода доставки:</p>
			
			<div style="margin-top: 15px; margin-bottom: 30px;">
				<table>
					<tr>
						<td style="background-color: #ffe400; padding: 10px;"><p style="font-family: Tahoma; color: #000000; font-size: 14px; font-weight: bold;">С 9:00</br>до 15:00</p></td>
						<td style="background-color: #ffcc00; padding: 10px;"><p style="font-family: Tahoma; color: #000000; font-size: 14px; font-weight: bold;">С 14:00</br>до 17:00</p></td>
						<td style="background-color: #ff9c00; padding: 10px;"><p style="font-family: Tahoma; color: #000000; font-size: 14px; font-weight: bold;">С 18:00</br>до 22:00</p></td>
					</tr>
				</table>
			</div>
			
			<p style="font-family: Tahoma; color: #000000; font-size: 14px; font-weight: bold;">В праздничные и выходные дни два периода доставки:</p>
			
			<div style="margin-top: 15px; margin-bottom: 30px;">
				<table>
					<tr>
						<td style="background-color: #ffe400; padding: 10px 30px;"><p style="font-family: Tahoma; color: #000000; font-size: 14px; font-weight: bold;">С 11:00</br>до 16:00</p></td>
						<td style="background-color: #ffcc00; padding: 10px 30px;"><p style="font-family: Tahoma; color: #000000; font-size: 14px; font-weight: bold;">С 18:00</br>до 22:00</p></td>
						
					</tr>
				</table>
			</div>
			
			<p style="font-family: Tahoma; color: #000000; font-size: 14px; margin-bottom: 30px;">Доставка оборудования происходит по будним дням с 9-00 до 18-00 в течение 3-х дней с момента заявки. Стоимость доставки уточняйте у оператора!</p>
			<p style="font-family: Tahoma; color: #000000; font-size: 12px; margin-bottom: 30px;">Обратите внимание! В зависимости от дорожного положения в городе, погодных условий и других факторов сроки и время доставки могут меняться.</p>
		</div>
		
		<div class="cb"></div>
	</div>
    
    <div class="block-text" id="otdalennie">
    	<p style="font-family: Tahoma; color: #000000; font-size: 12px;">*К удаленным районам относятся: пос. Северный, пос. Южный, пос. Плодородный, р-он Витаминкомбината, Ейского шоссе, Гор.хутор, р-он Рубероидного завода, ст. Елизаветенская, ст. Марьянская, ст. Новотитаровская, Знаменский, Старознаменский, Индустриальный, Дивный, х.Копанской, р-он Аэропорта, Восточный обход, Ростовское шоссе до 18 км от Краснодара, ближайшие поселения и с/т, находящиеся недалеко от трассы Немецкая деревня, Западный обход, 2-ое отд с/х Солнечный, Колосистый,  пос. Яблоновский, Тургеневское шоссе, Мега Адыгея, Радиорынок, Новознаменский, Хутор Ленина и другие . Список районов и условия доставки в них уточняйте у операторов!.</p>
	</div>
    <div class="block-text">
	
	<div class="block-text blue-bg" style="padding-top: 15px;">
		<h2 style="color: #ffffff;">Оплата</h2>
		<div style="padding: 0 30px;">
			<div class="payment__item">
				<p style="font-family: Tahoma; color: #ffffff; font-size: 14px; margin-bottom: 20px;"><strong>Наличными водителю.</strong></p>
				<p style="font-family: Tahoma; color: #ffffff; font-size: 14px;">При доставке воды, оборудования, аксессуаров и другой продукции нашего интернет-магазина домой или в офис Вы можете расплатиться наличными с нашим курьером.</p>
			</div>
			<div class="payment__item">
				<p style="font-family: Tahoma; color: #ffffff; font-size: 14px; margin-bottom: 20px;"><strong>Безналичный рассчет.</strong></p>
				<p style="font-family: Tahoma; color: #ffffff; font-size: 14px;">У нас имеется система безналичного расчета, с помощью которой Вы можете оплатить товар, перечислив деньги на счет.</p>
                <p style="font-family: Tahoma; color: #ffffff; font-size: 14px;">Счёт выставляется по запросу.</p>
			</div>
			<div class="payment__item">
				<p style="font-family: Tahoma; color: #ffffff; font-size: 14px; margin-bottom: 20px;"><strong>Банковской картой.**</strong></p>
				<p style="font-family: Tahoma; color: #ffffff; font-size: 14px; margin-bottom: 20px;">Всегда доступна оплата банковскими картами следующих платежных систем:</p>
				<div class="cards-item">
					<img src="{$THEME_IMG}/dostavka/mir-image.png">
					<img src="{$THEME_IMG}/dostavka/visa-image.png">
					<img src="{$THEME_IMG}/dostavka/mastercard-image.png">
				</div>	
			</div>			
		</div>
		<div class="before-order">
			<img src="{$THEME_IMG}/dostavka/attention.png">
			<p>При оформлении заявки на покупку оборудования убедительная просьба дождаться потверждения наличия товара на складе до его оплаты.</p>
		</div>
	</div>

	<div class="payement__link">
		<a target="_blank" href="https://securepayments.sberbank.ru/payment/docsite/payform-1.html?token=oc5a46dd26tm2c04u6nk2nprji&ask=amount&def=%7B%22email%22:%22700601@mail.ru%22%7D&def=%7B%22description%22:%22%25D0%259E%25D0%25BF%25D0%25BB%25D0%25B0%25D1%2582%25D0%25B0%2520%25D0%25B7%25D0%25B0%25D0%25BA%25D0%25B0%25D0%25B7%25D0%25B0%2520(%25D0%25BF%25D0%25BE%2520%25D1%2581%25D1%2581%25D1%258B%25D0%25BB%25D0%25BA%25D0%25B5)%22%7D&ask=%7B%22name%22:%22address%22,%22placeholder%22:%22%D0%90%D0%B4%D1%80%D0%B5%D1%81%20%D0%B4%D0%BE%D1%81%D1%82%D0%B0%D0%B2%D0%BA%D0%B8%22,%22label%22:%22%D0%90%D0%B4%D1%80%D0%B5%D1%81%20%D0%B4%D0%BE%D1%81%D1%82%D0%B0%D0%B2%D0%BA%D0%B8%22%7D">Ссылка для оплаты заказа</a>
	</div>
	
	<div class="block-text border-dot">
		<h2 style="font-weight: bold; font-size: 18px;">Приятных покупок!</h2>
	</div>

		<div class="return-goods">
			<h2>Правила возврата/обмена товара</h2>
			<p>1. Продовольственные товары (в т.ч. и питьевая вода) надлежащего качества обмену и возврату не подлежат.</p> 

			<p>2. При дистанционной торговле покупатель вправе отказаться от товара в любое время до передачи, а после передачи товара - в течение 7 дней при условии: товар не был в использовании, сохранены и не нарушены ярлыки и пломбы, сохранена упаковка.  При отказе покупателя от товара продавец возвращает сумму, уплаченную покупателем, за исключением расходов на доставку не позднее, чем через 10 дней от даты предъявления соответствующего требования.</p>

			<p>Кулеры и помпы для воды относятся относятся к перечню непродовольственных товаров надлежащего качества, не подлежащих возврату или обмену на аналогичный товар других размера, формы, габарита, фасона, расцветки или комплектации:</p>

			<p><span>"6. Изделия и материалы, контактирующие с пищевыми продуктами, из полимерных материалов, в том числе для разового использования (посуда и принадлежности столовые и кухонные, емкости и упаковочные материалы для хранения и транспортирования пищевых продуктов)</span></p> 

			 <p><span>11. Технически сложные товары бытового назначения, на которые установлены гарантийные сроки (станки металлорежущие и деревообрабатывающие бытовые; электробытовые машины и приборы; бытовая радиоэлектронная аппаратура; бытовая вычислительная и множительная техника; фото- и киноаппаратура; телефонные аппараты и факсимильная аппаратура; электромузыкальные инструменты; игрушки электронные, бытовое газовое оборудование и устройства)" 

			(в ред. Постановлений Правительства РФ от 20.10.1998 N 1222, от 06.02.2002 N 81)</span></p>

			<p>3. Претензии к внешнему виду доставленного Вам товара в соответствии со ст. 458 и 459 ГК РФ Вы можете предъявить только до передачи Вам товара продавцом. Ссылки на недостаточную освещенность помещения, поторапливания со стороны экспедитора и прочие причины, не являются основанием для выполнения Вами требований ст. 484 ГК РФ.</p>

			<p style="color: #002095;">Возврат переведенных средств, производится на Ваш банковский счет в течение 5—30 рабочих дней (срок зависит от Банка, который выдал Вашу банковскую карту)</p>
		</div>	

    	<h2 style="font-size: 14px; margin-top: 20px;">Описание процесса передачи данных</h2>
	
		<p style="font-family: Tahoma; color: #000000; font-size: 12px;">**Для оплаты (ввода реквизитов Вашей карты) Вы будете перенаправлены на платежный шлюз ПАО СБЕРБАНК. Соединение
с платежным шлюзом и передача информации осуществляется в защищенном режиме с использованием протокола
шифрования SSL. В случае если Ваш банк поддерживает технологию безопасного проведения интернет-платежей Verified
By Visa или MasterCard SecureCode для проведения платежа также может потребоваться ввод специального пароля.
Настоящий сайт поддерживает 256-битное шифрование. Конфиденциальность сообщаемой персональной информации
обеспечивается ПАО СБЕРБАНК. Введенная информация не будет предоставлена третьим лицам за исключением случаев,
предусмотренных законодательством РФ. Проведение платежей по банковским картам осуществляется в строгом
соответствии с требованиями платежных систем МИР, Visa Int. и MasterCard Europe Sprl.</p>
	</div>
	
	
{/block}