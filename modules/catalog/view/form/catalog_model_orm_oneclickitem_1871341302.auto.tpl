
<div class="formbox" >
            
    <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                    <li class=" active"><a data-target="#catalog-oneclickitem-tab0" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(0)}</a></li>
                    <li class=""><a data-target="#catalog-oneclickitem-tab1" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(1)}</a></li>
        
        </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none"/>
                        <div class="tab-pane active" id="catalog-oneclickitem-tab0" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                                            <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__user_fio->getTitle()}&nbsp;&nbsp;{if $elem.__user_fio->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__user_fio->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__user_fio->getRenderTemplate() field=$elem.__user_fio}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__user_phone->getTitle()}&nbsp;&nbsp;{if $elem.__user_phone->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__user_phone->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__user_phone->getRenderTemplate() field=$elem.__user_phone}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__title->getTitle()}&nbsp;&nbsp;{if $elem.__title->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__title->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__title->getRenderTemplate() field=$elem.__title}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__dateof->getTitle()}&nbsp;&nbsp;{if $elem.__dateof->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dateof->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__dateof->getRenderTemplate() field=$elem.__dateof}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__status->getTitle()}&nbsp;&nbsp;{if $elem.__status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__status->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__status->getRenderTemplate() field=$elem.__status}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__ip->getTitle()}&nbsp;&nbsp;{if $elem.__ip->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__ip->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__ip->getRenderTemplate() field=$elem.__ip}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__currency->getTitle()}&nbsp;&nbsp;{if $elem.__currency->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__currency->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__currency->getRenderTemplate() field=$elem.__currency}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__sext_fields->getTitle()}&nbsp;&nbsp;{if $elem.__sext_fields->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sext_fields->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__sext_fields->getRenderTemplate() field=$elem.__sext_fields}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__stext->getTitle()}&nbsp;&nbsp;{if $elem.__stext->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__stext->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__stext->getRenderTemplate() field=$elem.__stext}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__partner_id->getTitle()}&nbsp;&nbsp;{if $elem.__partner_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__partner_id->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__partner_id->getRenderTemplate() field=$elem.__partner_id}</td>
                                </tr>
                                
                                                            
                        </table>
                                                </div>
                        <div class="tab-pane" id="catalog-oneclickitem-tab1" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                            <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__source_id->getTitle()}&nbsp;&nbsp;{if $elem.__source_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__source_id->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__source_id->getRenderTemplate() field=$elem.__source_id}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__utm_source->getTitle()}&nbsp;&nbsp;{if $elem.__utm_source->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_source->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__utm_source->getRenderTemplate() field=$elem.__utm_source}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__utm_medium->getTitle()}&nbsp;&nbsp;{if $elem.__utm_medium->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_medium->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__utm_medium->getRenderTemplate() field=$elem.__utm_medium}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__utm_campaign->getTitle()}&nbsp;&nbsp;{if $elem.__utm_campaign->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_campaign->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__utm_campaign->getRenderTemplate() field=$elem.__utm_campaign}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__utm_term->getTitle()}&nbsp;&nbsp;{if $elem.__utm_term->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_term->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__utm_term->getRenderTemplate() field=$elem.__utm_term}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__utm_content->getTitle()}&nbsp;&nbsp;{if $elem.__utm_content->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_content->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__utm_content->getRenderTemplate() field=$elem.__utm_content}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__utm_dateof->getTitle()}&nbsp;&nbsp;{if $elem.__utm_dateof->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__utm_dateof->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__utm_dateof->getRenderTemplate() field=$elem.__utm_dateof}</td>
                                </tr>
                                
                                                            
                        </table>
                                                </div>
            
        </form>
    </div>
    </div>