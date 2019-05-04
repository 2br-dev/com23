<a href="{$router->getUrl('shop-front-cartpage')}" class="button checkout{if !$cart_info.has_error && $cart_info.items_count} active{/if}" id="checkout">Оформить заказ</a>
<div class="cart{if $cart_info.items_count} active{/if}" id="cart">
    <a href="/cart/" class="openCart"><span class="text">Корзина</span><i class="icon"></i></a>
    <a href="{$router->getUrl('shop-front-cartpage')}" class="showCart"><span class="floatCartAmount">{$cart_info.items_count}</span></a>
    <span class="floatCartPrice">{$cart_info.total}</span>
</div>