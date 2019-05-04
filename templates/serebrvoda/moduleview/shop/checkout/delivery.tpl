<form method="POST" class="formStyle checkoutBox" id="order-form">
    {if $order->hasError()}
        <div class="pageError">
            {foreach $order->getErrors() as $item}
            <p>{$item}</p>
            {/foreach}
        </div>
    {/if}
    <input type="hidden" name="delivery" value="0">
    <ul class="vertItems">
        {foreach $delivery_list as $item}
        {$something_wrong=$item->getTypeObject()->somethingWrong($order)}
        <li {if $item@first}class="first"{/if}>
            <div class="radio">
                <input type="radio" checked name="delivery" value="{$item.id}" id="dlv_{$item.id}" {if $order.delivery==$item.id}checked{/if} {if $something_wrong}disabled="disabled"{/if}>              
            </div>
            <div class="info">
                <div class="line">
                    <span class="price">
                        {if $something_wrong}
                            <span style="color:red;">{$something_wrong}</span>
                        {else}
                            <span class="help">{$order->getDeliveryExtraText($item)}</span>
                            {$order->getDeliveryCostText($item)}
                        {/if}
                    </span>
                    <label for="dlv_{$item.id}" class="title">{$item.title}</label>                    
                </div>
                <p class="descr">
                    {if !empty($item.picture)}
                       <img class="logoService" src="{$item.__picture->getUrl(100, 100, 'xy')}"/>
                    {/if}
                {$item.description}</p>
            </div>
        </li>
        {/foreach}
    </ul>
    <div class="buttons">
        <input type="submit" value="Далее" class="button red-color">
    </div>
    <div class="infoLine">
        <div class="infoLine__delivery">
            <p>Воду 19 л. и кулеры мы доставляем бесплатно</p>
            <p>При закаже воды только в мелкой таре:</p>
            <p>• на сумму менее 250 руб. - доставка 100 руб.<br>
            • на сумму более 250 руб. - доставка бесплатно.<br>
            • при отгрузке вместе с водой 19л.</p>
        </div>
        <div class="infoLine__info">
            <p>После оформления заказа наш менеджер свяжется с<br>вами в ближайшее время для уточнения деталей.</p>
        </div>
    </div>
</form>