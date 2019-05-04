<p>{t domain={$url->getDomainStr() order_num={$data->order.order_num}} }Уважаемый, администратор! На сайте %domain подтверждён заказ N %order_num{/t}.
<a href="{$router->getAdminUrl('edit', ["id" => $data->order.id], 'shop-orderctrl', true)}">{t}Перейти к заказу{/t}</a></p>

<p>{t}Автоматическая рассылка{/t} {$url->getDomainStr()}.</p>