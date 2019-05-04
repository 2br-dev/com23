{if $items}
    <ul class="menu">    
    {foreach from=$items item=item}
    	{if $item.fields.title != 'Сервис'}
            <li class="{if !empty($item.child)}node{/if}{if $item.fields.typelink=='separator'} separator{/if}{if $item.fields->isAct()} act{/if}" {if $item.fields.typelink != 'separator'}{$item.fields->getDebugAttributes()}{/if}>
            {if $item.fields.typelink!='separator'}<a title="{$item.fields.title}" href="{$item.fields->getHref()}" {if $item.fields.target_blank}target="_blank"{/if}>{$item.fields.title}</a>{else}&nbsp;{/if}
            </li>
    	{/if}
    {/foreach}
    </ul>
    <div class="headerMenuMobileBlock">
        <a class="headerMenuMobile__link">Меню</a>
    </div>
    <div class="headerMenuMobile">
        {foreach from=$items item=item}
            {if $item.fields.title != 'Сервис'}
                <div class="{if !empty($item.child)}node{/if}{if $item.fields.typelink=='separator'} separator{/if}{if $item.fields->isAct()} act{/if}" {if $item.fields.typelink != 'separator'}{$item.fields->getDebugAttributes()}{/if}>
                {if $item.fields.typelink!='separator'}<a href="{$item.fields->getHref()}" {if $item.fields.target_blank}target="_blank"{/if}>{$item.fields.title}</a>{else}&nbsp;{/if}
                </div>
            {/if}
        {/foreach}
        <a class="close_headerMenuMobile" id="close_headerMenuMobile">Х</a>
    </div>

{literal}
<script type="text/javascript">
    $(document).ready(function() {        
        $('.headerMenuMobile__link').click(function() {
            $('.headerMenuMobile').toggleClass('open_headerMenuMobile');
            $('#md_overlay').toggleClass('show_overlay');
            $('body').css("overflow", "hidden");
            //return false;
        });
        $('#close_headerMenuMobile').click(function(){
            $('.headerMenuMobile').toggleClass('open_headerMenuMobile');
            $('#md_overlay').toggleClass('show_overlay');
            $('body').css("overflow", "auto");
        });
    });
</script>
{/literal}

{else}
    {include file="%THEME%/block_stub.tpl"  class="noBack blockSmall blockLeft blockFootMenu" do=[
        {$this_controller->getSettingUrl()}    => t("Настройте блок")
    ]}
{/if}