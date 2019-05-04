{static_call var=all_props callback=['\Catalog\Model\PropertyApi', 'staticSelectListByType'] params=['list']}
{$multioffer_help_url='http://readyscript.ru/manual/catalog_products.html#catalog_multioffers'}

{if !empty($all_props)}
    <div id="multiOfferWrap">
        <div class="multiOfferWarning">
            &quot;Многомерные комплектации&quot; недоступны, т.к. у товара не добавлены или не отмеченны списковые характеристики. <a href="{$multioffer_help_url}" target="_blank" class="howTo">Подробнее...</a>
        </div>
        <div id="multiCheckWrap">
            <input type="checkbox" id="useMultiOffer" name="multioffers[use]" value="1" {if $elem->isMultiOffersUse()}checked{/if}> 
            <label for="useMultiOffer">{t}Использовать многомерные комплектации{/t}. <span><a href="{$multioffer_help_url}" target="_blank" class="howTo">Как использовать?</a></span></label>
        </div>


        <div class="multiOfferWrap">
            <div class="item">
                <table>
                    <tbody class="offersBody">
                        {if $elem->isMultiOffersUse()}
                            {$m=0}
                            {foreach $elem.multioffers.levels as $k=>$level}
                                <tr class="row">
                                    <td class="key">
                                       <div class="title">
                                          {t}Название параметра комплектации{/t}:
                                       </div> 
                                       <input type="text" name="multioffers[levels][{$m}][title]" maxlength="255" value="{$level.title}"/> 
                                    </td>
                                    <td class="value">
                                       <div class="title">
                                          {t}Списковые характеристики{/t}:
                                       </div>  
                                        {html_options name="multioffers[levels][{$m}][prop]" options=$all_props selected=$level.prop_id data-prop-id="{$k}"}
                                    </td>
                                    <td class="deleteLevelTd">
                                        <a href="#" class="deleteLevel">удалить</a>
                                    </td>
                                </tr>
                                {$m = $m+1}
                            {/foreach}
                        {/if}
                    </tbody>
                </table>
            </div>
            <div class="addWrap">
                <div class="keyval-container" data-id=".multiOfferWrap .row">
                    <a class=" addLevel" href="javascript:;">добавить параметр</a>
                </div>
                <div>
                   <input type="checkbox" id="createAutoOffers" name="offers[create_autooffers]" value="1" > 
                   <label for="createAutoOffers">{t}Создавать комплектации{/t} <a class="help-icon"
                    title="Установите данный флаг, если есть необходимость изменения цены<br/> или количества товара для разных комплектаций">?</a></label> 
                </div>
                <div class="bottomBar">
                    <input class="mbutton createComplexs" type="button" name="" value="cоздать"/>
                </div>
            </div>
        </div>

        {literal}
        <script type="text/x-tmpl" id="multioffer-line">
            <tr class="row">
                <td class="key">
                   <div class="title">
                   {/literal}
                      {t}Название параметра комплектации{/t}:
                   {literal}
                   </div> 
                   <input type="text" name="multioffers[levels][0][title]" maxlength="255"/> 
                </td>
                <td class="value">
                   <div class="title">
                      {/literal}  
                      {t}Списковые характеристики{/t}:
                      {literal}
                   </div>  
                   {/literal}
                  
                    {html_options name="multioffers[levels][0][prop]" options=$all_props data-prop-id="0"}
                   
                   {literal}
                </td>
                <td class="deleteLevelTd">
                    <a href="#" class="deleteLevel">удалить</a>
                </td>
            </tr>
        </script>
        {/literal}
    </div>
{/if}