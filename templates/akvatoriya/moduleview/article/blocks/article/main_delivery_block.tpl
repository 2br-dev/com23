{if $article.id}
<div class="deliveryBlock">
	<h1>Доставка воды в Краснодаре</h1>
    <!--<div class="image"><img src="{$THEME_IMG}/delivery.jpg"/></div>-->
         
        <div class="descr">{$article.content}</div>
    
	<div class="cb"></div>
</div>

{else}
    {include file="%THEME%/block_stub.tpl"  class="blockArticleDelivery" do=[
        [
            'title' => t("Добавьте статью о доставке"),
            'href' => {adminUrl do=false mod_controller="article-ctrl"}
        ],
        [
            'title' => t("Настройте блок"),
            'href' => {$this_controller->getSettingUrl()},
            'class' => 'crud-add'
        ]
    ]}
{/if}