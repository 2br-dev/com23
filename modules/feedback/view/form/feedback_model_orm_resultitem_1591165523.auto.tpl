
<div class="formbox" >
                
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="crud-form">
            <input type="submit" value="" style="display:none">
            <div class="notabs">
                                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                    
                
                
                                    <table class="otable">
                                                                                                                    
                                <tr>
                                    <td class="otitle">{$elem.__form_id->getTitle()}&nbsp;&nbsp;{if $elem.__form_id->getHint() != ''}<a class="help-icon" title="{$elem.__form_id->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__form_id->getRenderTemplate() field=$elem.__form_id}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__title->getTitle()}&nbsp;&nbsp;{if $elem.__title->getHint() != ''}<a class="help-icon" title="{$elem.__title->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__title->getRenderTemplate() field=$elem.__title}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__dateof->getTitle()}&nbsp;&nbsp;{if $elem.__dateof->getHint() != ''}<a class="help-icon" title="{$elem.__dateof->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__dateof->getRenderTemplate() field=$elem.__dateof}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__status->getTitle()}&nbsp;&nbsp;{if $elem.__status->getHint() != ''}<a class="help-icon" title="{$elem.__status->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__status->getRenderTemplate() field=$elem.__status}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__ip->getTitle()}&nbsp;&nbsp;{if $elem.__ip->getHint() != ''}<a class="help-icon" title="{$elem.__ip->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__ip->getRenderTemplate() field=$elem.__ip}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__stext->getTitle()}&nbsp;&nbsp;{if $elem.__stext->getHint() != ''}<a class="help-icon" title="{$elem.__stext->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__stext->getRenderTemplate() field=$elem.__stext}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__answer->getTitle()}&nbsp;&nbsp;{if $elem.__answer->getHint() != ''}<a class="help-icon" title="{$elem.__answer->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__answer->getRenderTemplate() field=$elem.__answer}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__send_answer->getTitle()}&nbsp;&nbsp;{if $elem.__send_answer->getHint() != ''}<a class="help-icon" title="{$elem.__send_answer->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__send_answer->getRenderTemplate() field=$elem.__send_answer}</td>
                                </tr>
                                                            
                        
                    </table>
                            </div>
        </form>
    </div>