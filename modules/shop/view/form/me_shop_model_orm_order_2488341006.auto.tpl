
    <div class="me_info">
        {t}Выбрано элементов:{/t} <strong>{$param.sel_count}</strong>
    </div>
	{if count($param.ids)==0}
		<div class="me_no_select">
            {t}Для группового редактирования необходимо отметить несколько элементов.{/t}
		</div>
	{else}


<div class="formbox" >
                
    <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                            <li class=" active"><a data-target="#shop-order-tab0" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(0)}</a></li>
                            <li class=""><a data-target="#shop-order-tab1" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(1)}</a></li>
            
        </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none">
                        <div class="tab-pane active" id="shop-order-tab0" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                            <table class="otable">
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-notify_user" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__notify_user->getName()}" {if in_array($elem.__notify_user->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-notify_user">{$elem.__notify_user->getTitle()}</label>&nbsp;&nbsp;{if $elem.__notify_user->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__notify_user->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__notify_user->getRenderTemplate(true) field=$elem.__notify_user}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-status" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__status->getName()}" {if in_array($elem.__status->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-status">{$elem.__status->getTitle()}</label>&nbsp;&nbsp;{if $elem.__status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__status->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__status->getRenderTemplate(true) field=$elem.__status}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-operator_id_inProcessing" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__operator_id_inProcessing->getName()}" {if in_array($elem.__operator_id_inProcessing->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-operator_id_inProcessing">{$elem.__operator_id_inProcessing->getTitle()}</label>&nbsp;&nbsp;{if $elem.__operator_id_inProcessing->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__operator_id_inProcessing->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__operator_id_inProcessing->getRenderTemplate(true) field=$elem.__operator_id_inProcessing}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-operator_id_success" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__operator_id_success->getName()}" {if in_array($elem.__operator_id_success->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-operator_id_success">{$elem.__operator_id_success->getTitle()}</label>&nbsp;&nbsp;{if $elem.__operator_id_success->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__operator_id_success->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__operator_id_success->getRenderTemplate(true) field=$elem.__operator_id_success}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-operator_id_cancelled" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__operator_id_cancelled->getName()}" {if in_array($elem.__operator_id_cancelled->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-operator_id_cancelled">{$elem.__operator_id_cancelled->getTitle()}</label>&nbsp;&nbsp;{if $elem.__operator_id_cancelled->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__operator_id_cancelled->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__operator_id_cancelled->getRenderTemplate(true) field=$elem.__operator_id_cancelled}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-change_order_status_inProcessing" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__change_order_status_inProcessing->getName()}" {if in_array($elem.__change_order_status_inProcessing->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-change_order_status_inProcessing">{$elem.__change_order_status_inProcessing->getTitle()}</label>&nbsp;&nbsp;{if $elem.__change_order_status_inProcessing->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__change_order_status_inProcessing->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__change_order_status_inProcessing->getRenderTemplate(true) field=$elem.__change_order_status_inProcessing}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-change_order_status_success" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__change_order_status_success->getName()}" {if in_array($elem.__change_order_status_success->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-change_order_status_success">{$elem.__change_order_status_success->getTitle()}</label>&nbsp;&nbsp;{if $elem.__change_order_status_success->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__change_order_status_success->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__change_order_status_success->getRenderTemplate(true) field=$elem.__change_order_status_success}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-change_order_status_cancelled" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__change_order_status_cancelled->getName()}" {if in_array($elem.__change_order_status_cancelled->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-change_order_status_cancelled">{$elem.__change_order_status_cancelled->getTitle()}</label>&nbsp;&nbsp;{if $elem.__change_order_status_cancelled->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__change_order_status_cancelled->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__change_order_status_cancelled->getRenderTemplate(true) field=$elem.__change_order_status_cancelled}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-change_order_status_waitforpay" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__change_order_status_waitforpay->getName()}" {if in_array($elem.__change_order_status_waitforpay->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-change_order_status_waitforpay">{$elem.__change_order_status_waitforpay->getTitle()}</label>&nbsp;&nbsp;{if $elem.__change_order_status_waitforpay->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__change_order_status_waitforpay->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__change_order_status_waitforpay->getRenderTemplate(true) field=$elem.__change_order_status_waitforpay}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-operator_id_waitforpay" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__operator_id_waitforpay->getName()}" {if in_array($elem.__operator_id_waitforpay->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-operator_id_waitforpay">{$elem.__operator_id_waitforpay->getTitle()}</label>&nbsp;&nbsp;{if $elem.__operator_id_waitforpay->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__operator_id_waitforpay->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__operator_id_waitforpay->getRenderTemplate(true) field=$elem.__operator_id_waitforpay}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-paid_time" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__paid_time->getName()}" {if in_array($elem.__paid_time->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-paid_time">{$elem.__paid_time->getTitle()}</label>&nbsp;&nbsp;{if $elem.__paid_time->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__paid_time->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__paid_time->getRenderTemplate(true) field=$elem.__paid_time}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-checked_by_accountant" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__checked_by_accountant->getName()}" {if in_array($elem.__checked_by_accountant->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-checked_by_accountant">{$elem.__checked_by_accountant->getTitle()}</label>&nbsp;&nbsp;{if $elem.__checked_by_accountant->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__checked_by_accountant->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__checked_by_accountant->getRenderTemplate(true) field=$elem.__checked_by_accountant}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-amount_bottles" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__amount_bottles->getName()}" {if in_array($elem.__amount_bottles->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-amount_bottles">{$elem.__amount_bottles->getTitle()}</label>&nbsp;&nbsp;{if $elem.__amount_bottles->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__amount_bottles->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__amount_bottles->getRenderTemplate(true) field=$elem.__amount_bottles}</div></td>
                            </tr>
                            
                        </table>
                                                </div>
                        <div class="tab-pane" id="shop-order-tab1" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                                            <table class="otable">
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-date_delivery" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__date_delivery->getName()}" {if in_array($elem.__date_delivery->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-date_delivery">{$elem.__date_delivery->getTitle()}</label>&nbsp;&nbsp;{if $elem.__date_delivery->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__date_delivery->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__date_delivery->getRenderTemplate(true) field=$elem.__date_delivery}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-period_delivery" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__period_delivery->getName()}" {if in_array($elem.__period_delivery->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-period_delivery">{$elem.__period_delivery->getTitle()}</label>&nbsp;&nbsp;{if $elem.__period_delivery->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__period_delivery->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__period_delivery->getRenderTemplate(true) field=$elem.__period_delivery}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-need_to_call" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__need_to_call->getName()}" {if in_array($elem.__need_to_call->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-need_to_call">{$elem.__need_to_call->getTitle()}</label>&nbsp;&nbsp;{if $elem.__need_to_call->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__need_to_call->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__need_to_call->getRenderTemplate(true) field=$elem.__need_to_call}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-operator_to_manage" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__operator_to_manage->getName()}" {if in_array($elem.__operator_to_manage->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-operator_to_manage">{$elem.__operator_to_manage->getTitle()}</label>&nbsp;&nbsp;{if $elem.__operator_to_manage->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__operator_to_manage->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__operator_to_manage->getRenderTemplate(true) field=$elem.__operator_to_manage}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-source_id" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__source_id->getName()}" {if in_array($elem.__source_id->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-source_id">{$elem.__source_id->getTitle()}</label>&nbsp;&nbsp;{if $elem.__source_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__source_id->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__source_id->getRenderTemplate(true) field=$elem.__source_id}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-utm_source" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__utm_source->getName()}" {if in_array($elem.__utm_source->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-utm_source">{$elem.__utm_source->getTitle()}</label>&nbsp;&nbsp;{if $elem.__utm_source->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_source->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__utm_source->getRenderTemplate(true) field=$elem.__utm_source}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-utm_medium" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__utm_medium->getName()}" {if in_array($elem.__utm_medium->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-utm_medium">{$elem.__utm_medium->getTitle()}</label>&nbsp;&nbsp;{if $elem.__utm_medium->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_medium->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__utm_medium->getRenderTemplate(true) field=$elem.__utm_medium}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-utm_campaign" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__utm_campaign->getName()}" {if in_array($elem.__utm_campaign->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-utm_campaign">{$elem.__utm_campaign->getTitle()}</label>&nbsp;&nbsp;{if $elem.__utm_campaign->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_campaign->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__utm_campaign->getRenderTemplate(true) field=$elem.__utm_campaign}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-utm_term" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__utm_term->getName()}" {if in_array($elem.__utm_term->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-utm_term">{$elem.__utm_term->getTitle()}</label>&nbsp;&nbsp;{if $elem.__utm_term->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_term->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__utm_term->getRenderTemplate(true) field=$elem.__utm_term}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-utm_content" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__utm_content->getName()}" {if in_array($elem.__utm_content->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-utm_content">{$elem.__utm_content->getTitle()}</label>&nbsp;&nbsp;{if $elem.__utm_content->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_content->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__utm_content->getRenderTemplate(true) field=$elem.__utm_content}</div></td>
                            </tr>
                                                        
                            <tr class="editrow">
                                <td class="ochk" width="20">
                                    <input id="me-shop-order-utm_dateof" title="{t}Отметьте, чтобы применить изменения по этому полю{/t}" type="checkbox" class="doedit" name="doedit[]" value="{$elem.__utm_dateof->getName()}" {if in_array($elem.__utm_dateof->getName(), $param.doedit)}checked{/if}></td>
                                <td class="otitle">
                                    <label for="me-shop-order-utm_dateof">{$elem.__utm_dateof->getTitle()}</label>&nbsp;&nbsp;{if $elem.__utm_dateof->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_dateof->getHint()|escape}">?</a>{/if}
                                </td>
                                <td><div class="multi_edit_rightcol coveron"><div class="cover"></div>{include file=$elem.__utm_dateof->getRenderTemplate(true) field=$elem.__utm_dateof}</div></td>
                            </tr>
                            
                        </table>
                                                </div>
            
        </form>
    </div>
    </div>
{/if}