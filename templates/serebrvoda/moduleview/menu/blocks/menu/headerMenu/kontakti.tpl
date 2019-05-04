{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
	{* Хлебные крошки *}
    {moduleinsert name="\Main\Controller\Block\BreadCrumbs"}
	
	<h1>Контакты</h1>
	<div class="wrap-map">
		<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=9mEKdswkzJ0wRtN4FtnXoGyzz_c69zQF&amp;width=100%&amp;height=720&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
	</div>
{/block}