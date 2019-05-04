</td></tr>
<tr>
    <td>Назначенный Оператор</td>    
    <td style="color: blue;">{$elem->getOperatoToManage()->name} {$elem->getOperatoToManage()->surname}</td>
    <td>{$elem.operator_to_manage}</td>
</tr>
<tr>
    <td colspan="2">
       <h3>Информация об обработке заказа</h3>
    </td>
</tr>

<tr>
                            <td><strong>Статус</strong></td>
                            <td><strong>Оператор</strong></td>
                            <td><strong>Время</strong></td>
                        </tr>

 <tr class="{cycle values=$hl name="order"}">
            <td class="otitle">
                В обработке
            </td>
            <td>
            {if $elem.operator_id_inProcessing != NULL}
                {$elem.operator_id_inProcessing}
            {else}
                -
            {/if}
            </td>
            <td>
            {if $elem.operator_id_inProcessing != NULL}
                {$elem.change_order_status_inProcessing}
            {else}
                -
            {/if}
            </td>
        </tr> 
        <tr class="{cycle values=$hl name="order"}">
            <td class="otitle">
               Выполнен и закрыт
            </td>
            <td>
            {if $elem.operator_id_success != NULL}
                {$elem.operator_id_success}
            {else}
                -
            {/if} 
            </td>
            <td>
            {if $elem.operator_id_success != NULL}
                {$elem.change_order_status_success}
            {else}
                -
            {/if}
            </td>
        </tr> 
        <tr class="{cycle values=$hl name="order"}">
            <td class="otitle">
               Отменен
            </td>
            <td>
            {if $elem.operator_id_cancelled != NULL}
                {$elem.operator_id_cancelled}
            {else}
                -
            {/if} 
            </td>
            <td>
            {if $elem.operator_id_cancelled != NULL}
                {$elem.change_order_status_cancelled}
            {else}
                -
            {/if}
            </td>
        </tr>  
        <tr class="{cycle values=$hl name="order"}">
            <td class="otitle">
               Ожидает оплаты:
            </td>
            <td>
            {if $elem.operator_id_waitforpay != NULL}
                {$elem.operator_id_waitforpay}
            {else}
                -
            {/if} 
            </td>
            <td>
            {if $elem.operator_id_waitforpay != NULL}
                {$elem.change_order_status_waitforpay}
            {else}
                -
            {/if}
            </td>
        </tr>      
    </tr>
    <tr>
        <td>Заказ оплачен:</td>
        {if $elem.paid_time != NULL}
        <td>{$elem.paid_time}</td>
        {else}
        <td> - </td>
        {/if}
    </tr>                    
<tr><td>                        