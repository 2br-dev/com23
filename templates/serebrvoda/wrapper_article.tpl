{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
    <div class="box">
        {* Хлебные крошки *}
        {moduleinsert name="\Main\Controller\Block\BreadCrumbs"}
        <div class="left75">
            {* Главное содержимое страницы *}
            {$app->blocks->getMainContent()}
        </div>
        <div class="right20">
            {* Недавние новости *}
            {moduleinsert name="\Article\Controller\Block\LastNews" indexTemplate="blocks/listnews/listnews.tpl" category="2" pageSize="5"}
        </div>
        <div class="clearBoth"></div>
    </div>
{/block}