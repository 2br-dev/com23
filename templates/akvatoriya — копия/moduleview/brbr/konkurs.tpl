{addjs file="%brbr%/vote.js"}
<h1>Конкурс</h1>

<div class="vote-container">    
    <div class="vote-container-info">
        <p>Мы организовали творческий тематический конкурс для детей сотрудников Единой службы доставки питьевой воды.
            Приглашаем оценить мастерство и фантазию. <br>
            Отдайте свой голос за самую лучшую работу! <br>
            Внимание! Можно проголосовать за 1 работу в каждой возрастной категории. </p>
        <p>Голосование открыто до 12:00 25 декабря 2018 г.</p>
    </div>
    {if !empty($list)}

        {if !empty($list.1)}
	        <div class="vote-container-header">
		        <h1 class="vote-container-header-text">РАБОТЫ ТВОРЦОВ 3-7 ЛЕТ</h1>
		        <!--<div class="vote-container-header-button">РАБОТЫ ТВОРЦОВ 8-14 ЛЕТ</div>-->
		        
		        	<p style="color: red;">Голосование закрыто</p>
		       
		    </div>
            <div class="vote-young">
                {foreach $list.1 as $item}
                    <div class='vote-item vote-young-item'>
                        <a href="{$item->getMainImage()->getUrl(800, 800)}">
                            <img src="{$item->getMainImage()->getUrl(200, 200, 'axy')}" title="№ {$item.title}" class="vote-image">
                        </a>
                        <div class="vote-text">
                            <p class="vote-number">№ {$item.title}</p>
                           
                                <p class="vote-result">Количество голосов: {$item->getVoices()}</p>
                           
                            {$images=$item->fillImages()}
                            <div class="vote-image-block">
                                {foreach $images as $image}
                                    <a href="{$image->getUrl(800, 800)}"><img src="{$image->getUrl(70, 70, 'axy')}" title="№ {$item.title}"></a>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        {/if}

        {if !empty($list.2)}
        <div class="vote-container-header">
		        <h1 class="vote-container-header-text">РАБОТЫ ТВОРЦОВ 8-14 ЛЕТ</h1>
		        <!--<div class="vote-container-header-button">РАБОТЫ ТВОРЦОВ 8-14 ЛЕТ</div>-->
		        
		        	<p style="color: red;">Голосование закрыто</p>
		        
		    </div>
            <div class="vote-old">
                {foreach $list.2 as $item}
                    <div class='vote-item vote-old-item'>
                        <a href="{$item->getMainImage()->getUrl(800, 800)}">
                            <img src="{$item->getMainImage()->getUrl(200, 200, 'axy')}" title="№ {$item.title}" class="vote-image">
                        </a>
                        <div class="vote-text">
                            <p class="vote-number">№ {$item.title}</p>
                           
                                <p class="vote-result">Количество голосов: {$item->getVoices()}</p>
                            
                            {$images=$item->fillImages()}
                            <div class="vote-image-block">
                                {foreach $images as $image}
                                    <a href="{$image->getUrl(800, 800)}"><img src="{$image->getUrl(70, 70, 'axy')}" title="№ {$item.title}"></a>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        {/if}

    {/if}

    <div class="vote-modal-wrapper">
        <div class="vote-modal">
            <div class="close-button"></div>
            <p class="vote-modal-header">ВЫ ГОЛОСУЕТЕ?</p>
            <p class="vote-modal-agree">ГОЛОС НЕЛЬЗЯ БУДЕТ ОТМЕНИТЬ</p>
            <div class="vote-modal-buttons">
                <p class="vote-modal-no">НЕТ</p>
                <p id="makeVote" class="vote-button make-vote" data-url="{$router->getUrl('brbr-front-vote', ['Act'=>'vote'])}">Голосовать</p>
            </div>
        </div>
    </div>

    <div class="vote-error-wrapper">
        <div class="vote-modal">
            <div class="close-button"></div>
            <p class="vote-modal-agree">Извините, но ваш голос, уже был учтён.</p>
            <div class="vote-modal-buttons">
                <p class="vote-button vote-check-result">Посмотреть результаты</p>
            </div>
        </div>
    </div>

    <div class="vote-success-wrapper">
        <div class="vote-modal">
            <div class="close-button"></div>
            <p class="vote-modal-agree">Cпасибо, ваш голос был учтён!</p>
            <div class="vote-modal-buttons">
                <p class="vote-button vote-check-result">Посмотреть результаты</p>
            </div>
        </div>
    </div>

    <div class="vote-wrapper"></div>
</div>

{* СТИЛИ *}
<style>
    .vote-image {
        width: 200px;
        height: 200px;
    }
    .vote-image-block img {
        width: 70px;
        height: 70px;
    }
    .vote-image:hover, .vote-image-block img:hover {
        -webkit-transition: .5s ease;
        -o-transition: .5s ease;
        transition: .5s ease;
        -webkit-box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    }
    .vote-container {
        font-family: 'Tahoma', sans-serif;
        width: 1000px;
        margin: 0 auto;
        text-align: center;
    }
    .vote-container-header {
        position: relative;
        margin-bottom: 25px;
    }
    .vote-number {
        font-size: 28px;
        color: #002095;
        margin: 0;
    }
    .vote-button {
        margin: 0;
        background: #ff0000;
        color: white;
        width: -webkit-fit-content;
        width: -moz-fit-content;
        width: fit-content;
        padding: 7px 15px;
        height: 37px;
    }
    .vote-button:hover {
        cursor: pointer;
        -webkit-transition: .5s ease;
        -o-transition: .5s ease;
        transition: .5s ease;
        -webkit-box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    }
    .vote-container-header-text {
        font-size: 40px;
        color: #002095;
        font-weight: 300;
        padding-top: 10px;
        margin-bottom: 0px;
    }
    .vote-container-info {
        font-size: 14px;
        width: 600px;
        margin: 0 auto 50px;
    }
    .vote-container-header-button {
        color: white;
        background: #0ac5fa;
        font-size: 14px;
        position: absolute;
        right: 0;
        top: 0;
        height: 45px;
        line-height: 35px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        padding: 5px 20px;
        font-weight: bold;
    }
    .vote-container-header-button:hover {
        cursor: pointer;
        -webkit-box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        -webkit-transition: .37s ease;
        -o-transition: .37s ease;
        transition: .37s ease;
    }
    .vote-modal-header {
        font-size: 22px;
        margin: 0;
    }
    .vote-modal-agree {
        font-size: 16px;
        margin: 0;
    }
    .vote-old, .vote-young {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
    }
    .vote-item {
        width: 450px !important;
        height: -webkit-fit-content;
        height: -moz-fit-content;
        height: fit-content;
        margin-bottom: 30px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;

    }
    .vote-text {
        text-align: left;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }
    .vote-modal-no {
        padding: 7px 30px;
        font-size: 18px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }
    .vote-modal-no:hover {
        -webkit-transition: .2s ease;
        -o-transition: .2s ease;
        transition: .2s ease;
        -webkit-box-shadow: inset 0 0 0 1px black;
        box-shadow: inset 0 0 0 1px black;
        cursor: pointer;
    }
    .vote-wrapper {
        background: rgba(0,0,0,0.62);
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        right: 0;
        z-index: 2;
        display: none;
    }
    .vote-modal-wrapper, .vote-error-wrapper, .vote-success-wrapper {
        display: none;
    }
    .vote-modal {
        position: fixed;
        background: white;
        -webkit-box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        width: 400px;
        height: 200px;
        margin: auto;
        z-index: 5;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-pack: space-evenly;
        -ms-flex-pack: space-evenly;
        justify-content: space-evenly;
    }
    .vote-modal-buttons {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: space-evenly;
        -ms-flex-pack: space-evenly;
        justify-content: space-evenly;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }
    .close-button {
        height: 30px;
        width: 30px;
        position: absolute;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        line-height: 50px;
        display: inline-block;
        right: 10px;
        top: 10px;
    }
    .close-button:before,
    .close-button:after {
        -webkit-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        transform: rotate(-45deg);
        content: '';
        position: absolute;
        margin-top: 12px;
        margin-left: 5px;
        display: block;
        height: 5px;
        width: 20px;
        background-color: #000;
        -webkit-transition: all 0.2s ease-out;
        -o-transition: all 0.2s ease-out;
        transition: all 0.2s ease-out;
    }
    .close-button:after {
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    .close-button:hover:before,
    .close-button:hover:after {
        -webkit-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
        cursor: pointer;
    }
    @media all and (max-width: 1024px) {
        .vote-container {
            width: 95%;
            margin: 0 auto;
        }
        .vote-item {
            margin: 0 auto 30px;
        }
    }
    @media all and (max-width: 640px) {
        .vote-container-header-button {
            left: 0;
            width: 80%;
            margin: auto;
            height: 55px;
            line-height: 45px;
        }
        .vote-container-header-text {
            padding-top: 70px;
        }
        .vote-container-info {
            width: 90%;
        }
    }
    @media all and (max-width: 425px) {
        .vote-item {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }
        .vote-text {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }
        .vote-image {
            width: 80%;
            height: 80%;
        }
        .vote-button {
            font-size: 24px;
            padding: 10px 50px;
            height: unset;
        }
        .vote-image-block {
            margin-top: 10px;
        }
        .vote-modal {
            width: 95%;
        }
        .vote-modal .vote-button {
            padding: 10px;
        }
    }
</style>