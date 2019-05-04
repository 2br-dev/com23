{* Файл генерируется автоматически исходя из полей объекта Order *}

<table class="otable">
                        
                <tr>
                <td class="otitle">{$elem.__create_refund_receipt->getTitle()}&nbsp;&nbsp;{if $elem.__create_refund_receipt->getHint() != ''}<a class="help-icon" title="{$elem.__create_refund_receipt->getHint()|escape}">?</a>{/if}
                </td>
                <td>{include file=$elem.__create_refund_receipt->getRenderTemplate() field=$elem.__create_refund_receipt}</td>
                </tr>
                    
                <tr>
                <td class="otitle">{$elem.__substatus->getTitle()}&nbsp;&nbsp;{if $elem.__substatus->getHint() != ''}<a class="help-icon" title="{$elem.__substatus->getHint()|escape}">?</a>{/if}
                </td>
                <td>{include file=$elem.__substatus->getRenderTemplate() field=$elem.__substatus}</td>
                </tr>
        
    
</table>