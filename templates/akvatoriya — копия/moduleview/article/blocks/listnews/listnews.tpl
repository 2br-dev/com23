{if $category && $news}
<ul class="news-list">
    {foreach $news as $item}
    <li {$item->getDebugAttributes()}>        
        <a href="{$item->getUrl()}" class="title">{$item.title}</a>
		<p class="date">{$item.dateof|dateformat:"%d %v %Y"}</p>
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