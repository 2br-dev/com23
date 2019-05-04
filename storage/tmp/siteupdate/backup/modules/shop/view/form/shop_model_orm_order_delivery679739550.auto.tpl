{* Файл генерируется автоматически исходя из полей объекта Order *}

            
            <tr>
            <td class="otitle">{$elem.__track_number->getTitle()}&nbsp;&nbsp;{if $elem.__track_number->getHint() != ''}<a class="help-icon" title="{$elem.__track_number->getHint()|escape}">?</a>{/if}
            </td>
            <td>{include file=$elem.__track_number->getRenderTemplate() field=$elem.__track_number}</td>
            </tr>
    
