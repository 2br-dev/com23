{static_call var=utm_decoded callback=['\evSourceBuster\Model\Utm','getSource'] params=[$elem.source_info]}
<table class="otable">
    
        <tr>
            <td class="otitle">Наименование</td>
            <td>{$utm_decoded.name}</td>
      
        </tr>
         <tr>
            <td class="otitle">Код</td>
       
            <td>{$utm_decoded.code}</td>
        </tr>
        <tr>
            <td class="otitle">Сырые данные</td>
            <td>{$elem.source_info}</td>
        </tr>
</table>