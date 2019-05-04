{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
    <div class="box">
        {* Хлебные крошки *}
        {moduleinsert name="\Main\Controller\Block\BreadCrumbs"}		
		
        <div class="productList mainContent">		
            {$app->blocks->getMainContent()}
        </div>
        <div class="lastViewedBlock">  
            
            {* Просмотренные товары *}
            {moduleinsert name="\Catalog\Controller\Block\LastViewed" pageSize="9"}            
            
        </div>        
        <div class="clearBoth"></div>
    </div>
{/block}