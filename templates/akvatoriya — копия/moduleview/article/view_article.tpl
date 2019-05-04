<article>
    <p class="date">{$article.dateof|dateformat:"@date @time"}</p>
    <h1>{$article.title}</h1>
    
    {if !empty($article.image)}
    <div class="mainImage"><img src="{$article.__image->getUrl(700, 304, 'xy')}"/></div>
    {/if}
    {$article.content}
</article>
{moduleinsert name="\Photo\Controller\Block\PhotoList" type="article" route_id_param="article_id"}