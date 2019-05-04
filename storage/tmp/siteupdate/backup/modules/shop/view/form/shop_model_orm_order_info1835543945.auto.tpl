{* Файл генерируется автоматически исходя из полей объекта Order *}

            
            <tr>
            <td class="otitle">{$elem.__operator->getTitle()}&nbsp;&nbsp;{if $elem.__operator->getHint() != ''}<a class="help-icon" title="{$elem.__operator->getHint()|escape}">?</a>{/if}
            </td>
            <td>{include file=$elem.__operator->getRenderTemplate() field=$elem.__operator}</td>
            </tr>
    
            
            <tr>
            <td class="otitle">{$elem.__source_info->getTitle()}&nbsp;&nbsp;{if $elem.__source_info->getHint() != ''}<a class="help-icon" title="{$elem.__source_info->getHint()|escape}">?</a>{/if}
            </td>
            <td>{include file=$elem.__source_info->getRenderTemplate() field=$elem.__source_info}</td>
            </tr>
    
            
            <tr>
            <td class="otitle">{$elem.__source_id->getTitle()}&nbsp;&nbsp;{if $elem.__source_id->getHint() != ''}<a class="help-icon" title="{$elem.__source_id->getHint()|escape}">?</a>{/if}
            </td>
            <td>{include file=$elem.__source_id->getRenderTemplate() field=$elem.__source_id}</td>
            </tr>
    
            
            <tr>
            <td class="otitle">{$elem.__id_yandex_market_cpa_order->getTitle()}&nbsp;&nbsp;{if $elem.__id_yandex_market_cpa_order->getHint() != ''}<a class="help-icon" title="{$elem.__id_yandex_market_cpa_order->getHint()|escape}">?</a>{/if}
            </td>
            <td>{include file=$elem.__id_yandex_market_cpa_order->getRenderTemplate() field=$elem.__id_yandex_market_cpa_order}</td>
            </tr>
    
