{if $category && $news}
<h3><a href="{$router->getUrl('article-front-previewlist', [category => $category->getUrlId()])}">Новости</a></h3>
<ul class="news">
    {foreach $news as $item}
    <li {$item->getDebugAttributes()} class="news-block-onMain">
        
        <a href="{$item->getUrl()}" class="news-block-onMain-title">{$item.title}</a>
		<p class="date">{$item.dateof|dateformat:"%d %v %Y"}</p>
		{if !empty($item.image)}
		<div class="news-block-onMain-image"><img src="{$item.__image->getUrl(130, 86, 'xy')}"/></div>
		{/if}
		<div class="news-block-onMaim-text">{$item.content}</div>
		<a href="{$item->getUrl()}" class="next">Читать далее</a>
    </li>
    {/foreach}
</ul>
{else}
    {include file="%THEME%/block_stub.tpl"  class="blockLastNews" do=[
        [
            'title' => t("Добавьте категорию с новостями"),
            'href' => {adminUrl do=false mod_controller="article-ctrl"}
        ],        
        [
            'title' => t("Настройте блок"),
            'href' => {$this_controller->getSettingUrl()},
            'class' => 'crud-add'
        ]        
    ]}
{/if}