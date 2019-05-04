{if $url->request('Act', $smarty.const.TYPE_STRING) != 'finish'}
<div class="yourcart">
    <p class="icon"></p>
    <a class="cartInfo co_count" href="{$router->getUrl('shop-front-cartpage')}">{$cart_info.items_count}</a>
    <a class="cartInfo" href="{$router->getUrl('shop-front-cartpage')}">на сумму <span style="color: #01269c;">{$cart_info.total}</span></a>    
</div>
{/if}