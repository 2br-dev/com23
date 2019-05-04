{static_call var=utm_decoded callback=['\evSourceBuster\Model\Utm','getSourceAuto'] params=[$elem.source_info]}
<table class="otable">
    
        <tr> 
          {if $utm_decoded.name} 
           <td>{$utm_decoded.name} {$utm_decoded.utm.src}</td>
          {else}
          <td>Нет данных</td>
          {/if} 
           
           
        </tr>             
       {if $elem.source_info} <tr>
            <td class="otitle">Сырые данные:</td>
            <td>{$elem.source_info}</td>
        </tr>                
       {/if} 
</table>