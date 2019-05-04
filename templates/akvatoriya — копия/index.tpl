{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
	<!--<div style="width: 100%; text-align: center;"><img src="{$THEME_IMG}/9may_2016.gif"/></div>-->
    </div>
    <div class="">
        {* Баннеры *}
        {moduleinsert name="\Banners\Controller\Block\Slider" zone="main-center"} 
         
    </div>
    <div class="viewport mainContent">
    <div class="box mt40">
        {* Лидеры продаж *}
        {moduleinsert name="\Catalog\Controller\Block\TopProducts" dirs="voda" }

        <!--<div class="light-start">
        	<div class="light-start__image">
        		<img src="{$THEME_IMG}/light-start.jpg"/>
        	</div>
        	<div class="light-start__button">
        		<a href="/cart/?add=255" class="button addToCart noShowCart" data-add-text="Добавлено">Купить</a>
        	</div>
        </div>-->

        <!-- Форма голосования -->
 		<!-- <form class="vote__form" id="vote__form">
 			<input type="hidden" name="vote_id" value="1">
 			<p class="vote__title">
 				Как вы оцениваете нашу работу?
 			</p>
 			<div class="vote__mark">
 				<div class="vote__mark_item">
 					<input type="radio" name="vote_mark" value="3" checked id="radio1"><label for="radio1"><span>Отлично</span></label>
 				</div>
 				<div class="vote__mark_item">
 					<input type="radio" name="vote_mark" value="2" id="radio2"><label for="radio2">Хорошо</label>
 				</div>
 				<div class="vote__mark_item">
 					<input type="radio" name="vote_mark" value="1" id="radio3"><label for="radio3">Терпимо</label>
 				</div>
 				<div class="vote__mark_item">
 					<input type="radio" name="vote_mark" value="0" id="radio4"><label for="radio4">Плохо</label>
 				</div>
 			</div>
 			<div class="vote__comment">
 				<textarea placeholder="Напишите, пожалуйста, здесь ваш комментарий"></textarea>
 				<input type="submit" value="Голосовать" id="vote_submit" data-modal="modal-1" class="md-trigger">
 				<div class="cb"></div>
 			</div> 			
 		</form> -->

 		<!-- Ответ - если голосует впервые -->
 		<!--<div class="vote__modal" id="vote__ok">
 			<p class="vote__modal_text">Спасибо за участие, Ваше мнение очень важно для нас!</p>
 			<a class="close_modal" id="vote__ok_close">Закрыть</a>
 		</div> -->
 		<!-- Ответ - если такой пользователь уже голосовал -->
 		<!-- <div class="vote__modal" id="vote__error">
 			<p class="vote__modal_text">Ваш голос уже был учтен ранее, спасибо!</p> 			
 			<a class="close_modal" id="vote__error_close">Закрыть</a>
 		</div> -->

 		{** {literal}
 		<script type="text/javascript">
 			$(document).ready(function(){
 				// Обработка нажатия кнопки Голосовать
			    $('#vote__form').submit(function(e){
			        e.preventDefault();
			        var mark = $('#vote__form input:checked').val();
			        var comment = $('#vote__form textarea').val();
			        var vote_id = $('#vote__form input[name="vote_id"]').val();
			        $.ajax({
			            url: 'http://com23.ru/vote.php',
			            type: 'POST',
			            dataType: "JSON", 
			            data: {
			                mark: mark,
			                comment: comment,
			                vote_id: vote_id
			            },
			            success: function(cb){
			            	
			            	if (cb.old_user == 1){
			            		$('#vote__error').addClass('show_modal');
			            		$('#md_overlay').addClass('show_overlay');
			            	}
			            	else if (cb.old_user == 0) {
			            		$('#vote__ok').addClass('show_modal');
			            		$('#md_overlay').addClass('show_overlay');
			            	}
			            },
			            error: function(cb){}
			        });        
			    });
 			});
 		</script>
 		{/literal} **}
        
        <div class="oh mt40">
        <h1>Доставка воды в Краснодаре</h1>
        <div class="delivery__block1">
            <div class="delivery__block1__item">
                <div class="box__img">
                    <img src="{$THEME_IMG}/saves_time.jpg" alt="Доставка воды экономит время">
                </div>
                <div class="delivery__block1__title">
                    <p class="like__h2">Экономит время</p>
                </div>
                <div class="delivery__block1__text">
                    <p>Вам не нужно самостоятельно ехать или идти в магазин, искать парковку и переносить емкости с водой. Мы всё привезём сами в удобный для вас интервал времени.</p>
                </div>                 
            </div>    
            <div class="delivery__block1__item">
                <div class="box__img">
                    <img src="{$THEME_IMG}/saves_power.jpg" alt="Доставка воды экономит силы">
                </div>
                <div class="delivery__block1__title">
                    <p class="like__h2">Экономит силы</p>
                </div>
                <div class="delivery__block1__text">
                    <p>Наши специалисты доставят воду к вашему порогу и установят бутыли с водой в указанное место. </p>
                </div>
            </div>    
            <div class="delivery__block1__item">
                <div class="box__img">
                    <img src="{$THEME_IMG}/saves_money.jpg" alt="Доставка воды экономит деньги">
                </div>
                <div class="delivery__block1__title">
                    <p class="like__h2">Экономит деньги</p>
                </div>
                <div class="delivery__block1__text">
                    <p>Питьевая вода в 19 л. бутылях стоит дешевле, по сравнению с разлитой в другие тары. А доставка ее к вам домой или в офис бесплатная.</p>
                </div>
            </div>
            <p class="delivery__block1__notice">Доставка воды в Краснодаре осуществляется от 1 бутыли.</p>    
        </div>
        <div class="delivery__block2">
            <h2>Доставляем воду в офис.</h2>
            <p>Люди, проводящие по 8 часов в день за компьютером, нуждаются в дополнительной поддержке здоровья. Первый шаг к нему – достаточное количество минералов и микроэлементов, которые содержатся в чистой и полезной питьевой воде. Кроме того, только чистая вода позволяет почувствовать настоящий вкус кофе или чая.</p>
        </div>
        <div class="delivery__block3">
            <h2>Привезем воду Вам домой.</h2>
            <p>Доставка воды в 19 л. бутылях - это выгодное и удобное решение по обеспечению чистой и полезной водой каждую квартиру или дом. Вы и все члены вашей семьи будете постоянно иметь под рукой чистую и полезную воду.</p>
            <p>Для Вашего удобства мы доставляем воду до 22:00, чтобы Вы могли заказать её, даже придя домой с работы.</p>
        </div>
        <div class="delivery__block4">
            <h3>Как заказать?</h3>
            <p>Заказать воду с доставкой в Краснодаре – просто и быстро. Для вашего удобства мы разработали несколько способов для заказов. Вы можете заказать доставку воды или оборудования для ее розлива круглосуточно:</p>
            <div class="delivery__block3__item">
                <div class="box__img">
                    <img src="{$THEME_IMG}/to_phone.png" alt="Заказ по телефону">
                </div>
                <div class="delivery__block3__title">
                    <p class="like__h3">По телефону</p>
                </div>
                <div class="delivery__block3__text">
                    <p>Ежедневно без праздничных и выходных дней:<br>  
                    с 08:00 до 20:00 заявку принимает менеджер<br> 
                    с 20:00 до 08:00 – автоответчик<br> 
                    Ночные заявки обрабатываются и подтверждаются менеджером утром следующего дня.
                    </p>
                </div>
            </div>
            <div class="delivery__block3__item">
                <div class="box__img">
                    <img src="{$THEME_IMG}/to_site.png" alt="Заказ через сайт">
                </div>
                <div class="delivery__block3__title">
                    <p class="like__h3">Через сайт</p>
                </div>
                <div class="delivery__block3__text">
                    <p>Заказывайте воду с доставкой на нашем сайте, с возможностью on-line оплаты. Воспользуйтесь всеми функциями нашего полноценного интернет-магазина.</p>
                    <div class="payement__link">
						<a target="_blank" href="https://securepayments.sberbank.ru/payment/docsite/payform-1.html?token=oc5a46dd26tm2c04u6nk2nprji&ask=amount&def=%7B%22email%22:%22700601@mail.ru%22%7D&def=%7B%22description%22:%22%25D0%259E%25D0%25BF%25D0%25BB%25D0%25B0%25D1%2582%25D0%25B0%2520%25D0%25B7%25D0%25B0%25D0%25BA%25D0%25B0%25D0%25B7%25D0%25B0%2520(%25D0%25BF%25D0%25BE%2520%25D1%2581%25D1%2581%25D1%258B%25D0%25BB%25D0%25BA%25D0%25B5)%22%7D&ask=%7B%22name%22:%22address%22,%22placeholder%22:%22%D0%90%D0%B4%D1%80%D0%B5%D1%81%20%D0%B4%D0%BE%D1%81%D1%82%D0%B0%D0%B2%D0%BA%D0%B8%22,%22label%22:%22%D0%90%D0%B4%D1%80%D0%B5%D1%81%20%D0%B4%D0%BE%D1%81%D1%82%D0%B0%D0%B2%D0%BA%D0%B8%22%7D">Ссылка для оплаты заказа</a>
					</div>
                </div>
            </div>
            <div class="delivery__block3__item">
                <div class="box__img">
                    <img src="{$THEME_IMG}/to_app.png" alt="Заказ через мобильное приложение">
                </div>
                <div class="delivery__block3__title">
                    <p class="like__h3">Через приложение</p>
                </div>
                <div class="delivery__block3__text">
                    <p>Мы не стоим на месте, а идем в ногу со временем и создали приложение для мобильных устройств с возможностью on-line оплаты заказов. </p>
                </div>
            </div>
        </div>
        <div class="delivery__block5">
            <h3>При первом заказе.</h3>
            <p>Если Вы ранее не пользовались питьевой водой в 19 л бутылях, то при первом заказе необходимо приобрести оборотную тару, в количестве равному числу бутылей воды в Вашем заказе. Её стоимость 250 рублей/шт. При повторных заказах вы платите только за воду, обменивая пустые бутыли на полные.</p>
        </div>
        <div class="delivery__block6">
            <h3>Как и когда мы доставляем воду.</h3>
            <p>Воду доставляют каждый день без праздничных и выходных ( кроме 1 января). Доставка питьевой воды в Краснодаре осуществляется бесплатно, то есть Вы платите только за продукт, а не за сервис.</p>
            <p>Для удобства наших клиентов мы предлагаем различные временные интервалы для доставки.</p>
            <div class="delivery__block6__item">
                <div  class="delivery__block6__item__title">
                    <p>В будние дни:</p>
                </div>
                <ul>
                    <li>с 09:00 до 15:00</li>
                    <li>с 12:00 до 17:00</li>
                    <li>с 18:00 до 22:00</li>
                </ul>
            </div>
            <div class="delivery__block6__item">
                <div  class="delivery__block6__item__title">
                    <p>В праздничные и выходные дни:</p>
                </div>
                <ul>
                    <li>с 11:00 до 16:00</li>
                    <li>с 18:00 до 22:00</li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>		
			<div class="advantages">
                <div class="viewport">
				<!--<div class="leaves-top">
					<img src="{$THEME_IMG}/leaves-top.jpg">
				</div>
				<div class="leaves-bottom">
					<img src="{$THEME_IMG}/leaves-bottom.jpg">
				</div>-->
				    <div class="adv-main-title-box">
					    <p class="adv-main-title">Наши преимущества</p>
					    <div class="cb"></div>
				    </div>
				    <div class="advantages-item">
					    <p class="adv-img"><img src="/templates/akvatoriya/resource/img/dostavka-image.png"/></p>
					    <p class="adv-title">Бесплатная доставка</p>
					    <div class="cb"></div>
					    <p class="adv-text">
					    Мы доставляем воду без прздничных и</br>
					    выходных дней, приемущественно в день заказа.
					    Доставка осуществляется бесплатно.
					    </p>
				    </div>
				    <div class="advantages-item">
					    <p class="adv-img"><img src="/templates/akvatoriya/resource/img/diler-image.png"/></p>
					    <p class="adv-title">Официальный дилер</p>
					    <div class="cb"></div>
					    <p class="adv-text">
					    Мы являемся официальными дилерами торговых
					    марок: "Домбай", "Архыз", "Горная вершина",</br>
					    "Пилигрим", "Софийский ледник" и др.
					    </p>
				    </div>
				    <div class="advantages-item">
					    <p class="adv-img"><img src="/templates/akvatoriya/resource/img/assortiment-image.png"/></p>
					    <p class="adv-title">Широкий ассортимент</p>
					    <div class="cb"></div>
					    <p class="adv-text">
					    Мы предлагаем более 10 торговых марок питьевой
					    воды, более 40 моделей кулеров и другого</br>
					    оборудования для розлива воды.
					    </p>	
				    </div>
				    <div class="advantages-item">
					    <p class="adv-img"><img src="/templates/akvatoriya/resource/img/periodi-image.png"/></p>
					    <p class="adv-title">Три периода доставки</p>
					    <div class="cb"></div>
					    <p class="adv-text">
					    будни с 9-00 до 15-00, с 12-00 до 17-00</br>
					    и с 18-00 до 22-00.</br>
					    праздники и выходные с 11-00 до 16-00</br> 
					    и с 18-00 до 22-00.
					    </p>
				    </div>
				    <div class="advantages-item">
					    <p class="adv-img"><img src="/templates/akvatoriya/resource/img/24hour-image.png"/></p>
					    <p class="adv-title">Круглосуточный заказ</p>
					    <div class="cb"></div>
					    <p class="adv-text">
					    Прием заказов круглосуточно: с 8-00 до 20-00</br>
					    работают операторы, с 20-00 до 8-00 работает автоответчик.</br> 
					    Так же в любое время доступен on-line заказ.
					    </p>
				    </div>
				    <div class="advantages-item">
					    <p class="adv-img"><img src="/templates/akvatoriya/resource/img/bestprice-image.png"/></p>
					    <p class="adv-title">Лучшая цена</p>
					    <div class="cb"></div>
					    <p class="adv-text">
					    Собственное производство и прямые поставки</br>
					    от компаний партнеров дают возможность</br>
					    предложить выгодные цены и акции для наших</br> 
					    клиентов.
					    </p>
				    </div>
                </div>				
				<!--<table>
					<tr>
						<td>
							<p class="adv-img"><img src="/templates/akvatoriya/resource/img/dostavka-image.png"/></p>
							<p class="adv-title">Бесплатная доставка</p>
							<div class="cb"></div>
							<p class="adv-text">
							Мы доставляем воду без прздничных и выходных
							дней, приемущественно в день заказа.</br>
							Доставка осуществляется бесплатно.
							</p>
						</td>
						<td>
							<p class="adv-img"><img src="/templates/akvatoriya/resource/img/diler-image.png"/></p>
							<p class="adv-title">Официальный дилер</p>
							<div class="cb"></div>
							<p class="adv-text">
							Мы являемся официальными дилерами торговых
							марок: "Домбай", "Архыз", "Горная вершина",</br>
							"Пилигрим", "Софийский ледник" и др.
							</p>
						</td>
						<td>
							<p class="adv-img"><img src="/templates/akvatoriya/resource/img/assortiment-image.png"/></p>
							<p class="adv-title">Широкий ассортимент</p>
							<div class="cb"></div>
							<p class="adv-text">
							Мы предлагаем 9 торговых марок питьевой
							воды, более 40 моделей кулеров и другого</br>
							оборудования для розлива воды.
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="adv-img"><img src="/templates/akvatoriya/resource/img/periodi-image.png"/></p>
							<p class="adv-title">Три периода доставки</p>
							<div class="cb"></div>
							<p class="adv-text">
							будни с 9-00 до 15-00, с 14-00 до 18-00</br>
							и с 18-00 до 22-00.</br>
							праздники и выходные с 11-00 до 16-00</br> 
							и с 18-00 до 22-00.
							</p>
						</td>
						<td>
							<p class="adv-img"><img src="/templates/akvatoriya/resource/img/24hour-image.png"/></p>
							<p class="adv-title">Круглосуточный заказ</p>
							<div class="cb"></div>
							<p class="adv-text">
							Прием заказов круглосуточно: с 8-00 до 20-00</br>
							работают операторы, с 20-00 до 8-00 работает автоответчик.</br> 
							Так же в любое время доступен on-line заказ.
							</p>
						</td>
						<td>
							<p class="adv-img"><img src="/templates/akvatoriya/resource/img/bestprice-image.png"/></p>
							<p class="adv-title">Лучшая цена</p>
							<div class="cb"></div>
							<p class="adv-text">
							Собственное производство и прямые поставки</br>
							от компаний партнеров дают возможность</br>
							предложить выгодные цены и акции для наших</br> 
							клиентов.
							</p>
						</td>
					</tr>
				</table>-->			
			</div>   
            <div class="viewport mainContent">
            {* Новости *}
            {moduleinsert name="\Article\Controller\Block\LastNews" indexTemplate="blocks/lastnews/lastnews.tpl" category="2" pageSize="4"}           
            
			
           
        </div>
        {* Товары во вкладках 
        {moduleinsert name="\Catalog\Controller\Block\ProductTabs" categories=["populyarnye-veshchi", "novye-postupleniya"] pageSize=6}
        
         Бренды 
        {moduleinsert name="\Catalog\Controller\Block\BrandList"}*}
    </div>
{/block}