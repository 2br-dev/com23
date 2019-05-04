{addcss file="{$mod_css}checkupdates.css" basepath="root"}
{addjs file="{$mod_js}checkupdates.js" basepath="root"}

<div class="checkUpdatesWidget" data-checkupdate-url="{adminUrl mod_controller="siteupdate-widget-checkupdates" cudo="checkUpdates"}">
    {if $state=='nolicense'}
        <div class="nolicense">
            <p>{t}Лицензионный ключ не установлен. Получение обновлений недоступно{/t}</p>
            <a class="greenButton" href="{adminUrl do=false mod_controller="main-license"}">{t}установить лицензию{/t}</a>
        </div>
    {elseif $state=='actual'}
        <div class="padd5">
            <table class="frame60 allok">
                <tr>
                    <td class="checkForUpdates">{t}Система обновлена до последней версии{/t}</td>
                </tr>
            </table>
            <table class="frame40 timeleft">
                <tr>
                    <td>
                        <a href="{adminUrl do=false mod_controller="main-license"}"><span class="l1">{t expire=$expire_days}%expire [plural:%expire:день|дня|дней]{/t}</span><br>
                            <span class="l2">{t}срок подписки на обновления{/t}</span></a>
                    </td>                            
                </tr>
            </table>
        </div>
    {elseif $state=='needupdate'}
        <div class="padd5">
            <div class="frame60">
                <p class="updateText checkForUpdates">{t}Доступны новые обновления{/t}</p>
                <table class="needUpdate">
                    <tr>
                        <td class="gotoUpdate">
                            <a href="{adminUrl do=false mod_controller="siteupdate-wizard"}#start" class="hasUpdate"><img src="{$mod_img}/checkupdates.png"><span>выполнить обновление</span></a>
                        </td>
                    </tr>
                </table>
            </div>
            <table class="frame40 timeleft">
                <tr>
                    <td>
                        <a href="{adminUrl do=false mod_controller="main-license"}"><span class="l1">{t expire=$expire_days}%expire [plural:%expire:день|дня|дней]{/t}</span><br>
                            <span class="l2">{t}срок подписки на обновления{/t}</span></a>
                    </td>
                </tr>
            </table>
        </div>
    {elseif $state=='expirelicense'}
        <div class="padd5">
            <table class="frame60">
                <tr>
                    <td>
                        {if $has_updates}
                            <p class="updateText checkForUpdates">{t}Доступны новые обновления{/t}</p>
                        {/if}
                        
                        {if $expire_sale}
                            <p class="updateBestPrice">Продлите подписку на обновления со <b>скидкой 30%</b> до {$expire_sale|dateformat:"@date @time"} (осталось {$expire_sale_days} дней)
                                <a class="whiteButton" href="{$expire_sale_buy_url}" target="_blank">{t}продлить подписку{/t}</a>
                            </p>
                        {else}
                            <p class="updateBestPrice">
                                {t}Срок доступных обновлений истек. <br>Продлите подписку на обновление продукта.{/t}
                                <a class="whiteButton" href="{$expire_sale_buy_url}" target="_blank">{t}продлить подписку{/t}</a>
                            </p>
                        {/if}
                    </td>
                </tr>
            </table>
            <table class="frame40 timeleft">
                <tr>
                    <td>
                        <span class="l1">{t}Срок подписки истек{/t}</span>
                    </td>
                </tr>
            </table>                    
        </div>
    {elseif $state=='error'}
        <div class="errors">
            <p class="msg">{$msg}</p>
            <a class="checkForUpdates">{t}повторить попытку{/t}</a>
        </div>
    {else}
        <div class="checking">
            <img src="{$Setup.IMG_PATH}/adminstyle/ajax-loader.gif"><br>
            <p>{t}Идет проверка обновлений{/t}</p>
        </div>
    {/if}
</div>

<script>
    $.allReady(function() {
        $('.checkUpdatesWidget').checkUpdates();
    });
</script>