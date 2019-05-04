{addjs file='%eridan%/remote_address_order.js'}

{$address=$elem->getAddress(false)}

<p style="margin-bottom: 0px; border-top: 1px solid #000; padding-top: 10px;">
	<input style="margin-right: 20px;" id="{$adress.id}_discount" class="is_remote_region" name="is_remote_region" data-url="{$router->getAdminUrl('toggleUserAddress', [], 'eridan-tools')}" type="checkbox" value="{$address.id}" {if $address.is_remote_region}checked{/if}/><label for="{$adress.id}_remote">Особый адрес доставки (отдаленный район)</label>
</p>
<p>
	<input style="margin-right: 20px;" id="{$adress.id}_discount" class="is_remote_region" name="is_discount_region" data-url="{$router->getAdminUrl('toggleUserAddress', [], 'eridan-tools')}" type="checkbox" value="{$address.id}" {if $address.is_discount_region}checked{/if}/><label for="{$adress.id}_discount">Льготный адрес доставки</label>
</p>
