{addjs file='%eridan%/remote_address.js'}
<ul id="eridanUserAdress" class="eridanUserAdress" data-url="{$router->getAdminUrl('toggleUserAddress', [], 'eridan-tools')}">
    {foreach from=$elem->getUserAddress() item=adress}
        <li>
        	<p class="userAddressList_adress" style="font-weight: bold; color: blue;">
        		{$adress.city}, {$adress.address}
        	<p>
            <p class="userAddressList_check" style="margin-bottom: 0px;">
            	<input type="checkbox" id="{$adress.id}_remote" name="is_remote_region" value="{$adress.id}" style="margin-right: 20px;"
            	{if $adress.is_remote_region}checked{/if}/><label for="{$adress.id}_remote">Особый адрес доставки (отдаленный район)</label>
            </p>
            <p class="userAddressList_check">
            	<input type="checkbox" id="{$adress.id}_discount" name="is_discount_region" value="{$adress.id}" style="margin-right: 20px;" {if $adress.is_discount_region}checked{/if}/><label for="{$adress.id}_discount">Льготный адрес доставки</label>
            </p>
        </li>
    {/foreach}
</ul>

