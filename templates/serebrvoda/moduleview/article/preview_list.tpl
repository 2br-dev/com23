<div class="newsPage">
    <h1 class="newsTitle">Новости</h1>
    <ul class="news">
        {foreach $list as $item}
        <li class="news-block-onMain" {$item->getDebugAttributes()}>
            <a href="{$item->getUrl()}" class="news-block-onMain-title">{$item.title}</a>
			<p class="date">{$item.dateof|date_format:"d.m.Y"}</p>
			{if !empty($item.image)}
			<div class="news-block-onMain-image"><img src="{$item.__image->getUrl(132, 86, 'xy')}"/></div>
			{/if}
            <div class="news-block-onMaim-text">{$item.content}</div>
			<a href="{$item->getUrl()}" class="next">Читать далее</a>
        </li>                  
        {/foreach}
    </ul>
    {include file="%THEME%/paginator.tpl"}          
</div>