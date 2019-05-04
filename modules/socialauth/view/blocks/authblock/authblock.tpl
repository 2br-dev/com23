<style type="text/css">
    .uLoginWrapper{
        min-height:35px;
        margin-top:10px;
        margin-bottom:10px;
        display: inline-block;
    }

    .uLoginWrapper .error{
        color:red;
        font-size:12px;
    }
</style>
<div class="uLoginWrapper">
    {if $error}
        <p class="error">{$error}</p>
    {/if}
    {$show_type=$this_controller->getParam('show_type')}
    {if $show_type!="window"} {* Отображение кнопками *}
        <div id="uLogin" data-ulogin="display={$this_controller->getParam('show_type')};fields=first_name,last_name,email;optional=phone;verify=1;{if $this_controller->getParam('no_mobile_buttons')}mobilebuttons=0;{/if}{$providers_code};redirect_uri={$redirect_uri}"></div>
    {else}
        <a href="#" id="uLoginbc6ea0f5" data-ulogin="display=window;fields=first_name,last_name,email;optional=phone;verify=1;{if $this_controller->getParam('no_mobile_buttons')}mobilebuttons=0;{/if}redirect_uri={$redirect_uri}"><img src="//ulogin.ru/img/button.png" width=187 height=30 alt="{t}МультиВход{/t}"/></a>
    {/if}
</div>
<script src="//ulogin.ru/js/ulogin.js"></script>

