{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
	<!--<div style="width: 100%; text-align: center;"><img src="{$THEME_IMG}/9may_2016.gif"/></div>-->
    {* Баннеры *}
    {moduleinsert name="\Banners\Controller\Block\Slider" zone="main-center"} 	

    <div class="box mainContent">     
    {* Лидеры продаж *}
    {moduleinsert name="\Catalog\Controller\Block\TopProducts" dirs="voda-v-tare-19-l"}      
       <div class="main_text_delivery">
       		<div class="main_text_block">
       			<h1>Доставка воды в Новороссийске.</h1>
       			<p>Заботитесь о своем здоровье и здоровье близких? - мы поможем Вам в этом.</p>
       			<p>Сервис доставки питьевой воды давно уже зарекомендовал себя. Миллионы людей всего мира ощутили преимущества данной услуги, мы предлагаем сделать это и Вам.</p>
       			<p>Мы доставим воду, поднимем на этаж и установим бутыль на кулер или поставим помпу. В нашем ассортименте: Серебряная, Мирабель, Горячий Ключ. Так же мы официальные дилеры торговых марок: Архыз, Долина Джентау (данная торговая марка представлена эксклюзивно только у нас), Горная вершина, Пилигрим, Домбай и др.</p>
       		</div>
       		<div class="main_text_block">
       			<h2>Вода НА ДОМ.</h2>
       			<p>Современный ритм жизни ускоряется год за годом. Сегодня у людей нет времени чтоб, приготовить себе здоровую еду, не говоря уже о том, чтобы позаботиться о наличии необходимого запаса чистой и качественной питьевой водой у себя дома. И это не нужно!!! Ведь есть мы! - мы доставим воду прямо к вашему порогу в день заказа.</p>
       			<p>Вам лишь важно помнить - что употребление в пищу чистой и качественной питьевой поможет сохранить Вам прекрасное здоровье на долгие годы. Ведь человек более чем на 70% процентов состоит из воды. Она - источник энергии и здоровья для человека. Не лучше ли заранее позаботиться о ее качестве?</p>
       			<p>Мы доставляем воду в день заказа. Просто позвоните Нам, и в этот же день она будет у Вас.</p>
       		</div>
       		<div class="main_text_block">
       			<h2>ДОСТАВКА питьевой ВОДЫ В ОФИС.</h2>
       			<p>Доставка воды в офис - наиболее удобный и доступный способ обеспечить всех сотрудников вашей фирмы неиссякаемым запасом энергии и жизненных сил.</p>
       			<p>Давно уже доказано, что употребление чистой, насыщенной природными минералами и микроэлементами воды помогает быть бодрым и внимательным, сохраняя высокую работоспособность в течении всего рабочего дня, потому что, большая ее часть в организме содержится в головном мозге.</p>
       			<p>Внимание руководители маленьких и больших фирм! - возьмите эту информацию на заметку. Обеспечьте, себя и своих сотрудников прекрасной природной питьевой водой, заказав ее доставку у нас.</p>
       			<p>Вся вода которую мы доставляем имеет необходимые сертификаты качества. Ее широкий ассортимент, с различным составом микроэлементов, позволит выбрать наиболее подходящую по вашему вкусу.</p>
       		</div>
       		<div class="main_text_delivery_sep"></div>       		
       </div>
        <div class="oh mt40">		
			<div class="advantages">
				<div class="advantages-item">
					<p class="adv-title"><img  class="adv-img" src="/templates/serebrvoda/resource/img/24-hour.png" alt="Круглосуточно принимаем заказы"/> Круглосуточно принимаем заказы</p>
					<div class="cb"></div>
				</div>
				<div class="advantages-item">
					<p class="adv-title"><img class="adv-img" src="/templates/serebrvoda/resource/img/delivery.png" alt="Привозим в день заказ"/> Привозим в день заказ</p>
					<div class="cb"></div>					
				</div>
				<div class="advantages-item">
					<p class="adv-title"><img class="adv-img" src="/templates/serebrvoda/resource/img/choice.png" alt="Широкий выбор воды в крупной и мелкой таре"/> Широкий выбор воды в крупной и мелкой таре</p>
					<div class="cb"></div>					
				</div>
				<div class="advantages-item">
					<p class="adv-title"><img class="adv-img" src="/templates/serebrvoda/resource/img/service.png" alt="Санитарное обслуживание и ремонт кулеров"/> Санитарное обслуживание и ремонт кулеров</p>
					<div class="cb"></div>					
				</div>		
			</div> 
			<div class="periody-dostavki">
				<div class="periody__text">
					<div style="float: left; background-color: #1f3fa5; padding: 15px 0px 15px 15px; min-height: 150px; box-sizing: border-box;">
						<p>Вы сами выбираете<br>период доставки</p>
						<p>Клиент при оформлении заказа может<br>выбрать убодный интервал</p>
					</div>
					<div style="float: left">
						<img src="{$THEME_IMG}/right-triangle.jpg" alt="Оформление">
					</div>
				</div>				
				<div class="periody__time">
					<p>09:00 - 13:00</p>
					<p>14:00 - 17:00</p>
					<p>18:00 - 21:00</p>
				</div>
			</div>
		</div>
	</div>
	<div class="bbdot"></div>
	
	

    <div class="mainContent mt40">
    	<div class="oh">
    		<div class="main__info">
    			<!--<div class="main__text">
    				<img src="{$THEME_IMG}/bottle.jpg" class="main__text_img">
    				<div class="main__text_desc">
    					<h3 class="h1_main__text" style="text-align: left;">Доставка воды в бутылях по 19 литров</h3>
    					<p>- это удобный и разумный способ обеспечить себя, свою семью или своих коллег чистой питьевой водой. Покупая в Новороссийске воду в бутылях с доставкой на дом или в офис, вы экономите своё время и средства.</p>
    				</div>
    			</div>-->
    			<div class="zakaz__text">
    				<h3 class="h2_main__text">Как оформить заказ?</h3>
    				<p>по телефону с 8:00 до 20:00 ваш заказ примет оператор,
					в любое другое время заказ будет записан автоответчиком.
					Через сайт можно оформить заказ в любое время.</p>
    			</div>
    			<div class="text_delivery_conditions">
    				<div class="main_text_delivery_sep"></div>
    				<h3>Условия доставки</h3>
    				<p>Мы доставляем воду в Новороссийске бесплатно и преимущественно в день заказа.</p>
    				<p>Существует три периода доставки, в том числе вечерний с 18 до 22 - и это несомненно удобно для всех работающих горожан. При заказе воды, вы выбираете наиболее подходящий для вас период - и мы осуществляем доставку.</p>
    				<p>Конечно, мы не волшебники.... и чтобы мы смогли доставить воду в день заказа - вам необходимо сделать заказ до 15-00.</p>
    				<p>Заказать доставку воды вы сможете и ночью, ведь мы принимаем заказы круглосуточно. После 20-00 Ваш заказ примет автоответчик, а утром он будет обработан оператором в первую очередь.</p>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="bbdot"></div>
    {moduleinsert name="\Catalog\Controller\Block\TopProducts" dirs="kulery" }

    <div class="mainContent mt40">
    	<div class="oh">
    		<div class="kuler__info">
    			<div class="kuler__text">    				
    				<div class="kuler__text_desc">
    					<h2 class="h2_kuler__text">У нас Вы можете купить кулер (раздатчик) для розлива воды.</h2>
    					<p>Широкий ассортимент, разнообразие представленных марок и модификаций позволят подобрать кулер для дома или офиса на любой вкус и любые потребности.</p>
    				</div>
    			</div>
    			<div class="kuler__assortiment">
    				<h3 class="h3_kuler__text">В нашем каталоге кулеров:</h3>
    				<p>- компрессорыне и электронные кулеры;<br>
					- напольные и настольные кулеры;<br>
					- кулеры без охлаждения (чайники);</p>
    			</div>
    		</div>
    	</div>
    </div>

			{* Доставка воды 
            {moduleinsert name="\Article\Controller\Block\Article" indexTemplate="blocks/article/main_delivery_block.tpl" article_id="dostavka"}*}
			
            {* Новости 
            {moduleinsert name="\Article\Controller\Block\LastNews" indexTemplate="blocks/lastnews/lastnews.tpl" category="2" pageSize="4"}*}           
            
			
           
        {* Товары во вкладках 
        {moduleinsert name="\Catalog\Controller\Block\ProductTabs" categories=["populyarnye-veshchi", "novye-postupleniya"] pageSize=6}
        
         Бренды 
        {moduleinsert name="\Catalog\Controller\Block\BrandList"}*}
    
{/block}