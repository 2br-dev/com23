{if $paginator->total_pages>1}
    <div class="paginator">        
        <div class="pages">
        {foreach from=$paginator->getPageList() item=page}            
            <a href="{$page.href}" {if $page.act}class="act"{/if}>{if $page.class=='left'}&laquo;{$page.n}{elseif $page.class=='right'}{$page.n}&raquo;{else}{$page.n}{/if}</a>
        {/foreach}
        </div>
		<div style="clear: both;"></div>
    </div>
{/if}