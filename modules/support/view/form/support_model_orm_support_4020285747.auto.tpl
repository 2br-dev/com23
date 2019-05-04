
<div class="formbox" >
                
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="crud-form">
            <input type="submit" value="" style="display:none">
            <div class="notabs">
                                                                                                            
                                                                                            
                    
                
                
                                    <table class="otable">
                                                                                                                    
                                <tr>
                                    <td class="otitle">{$elem.__dateof->getTitle()}&nbsp;&nbsp;{if $elem.__dateof->getHint() != ''}<a class="help-icon" title="{$elem.__dateof->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__dateof->getRenderTemplate() field=$elem.__dateof}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__message->getTitle()}&nbsp;&nbsp;{if $elem.__message->getHint() != ''}<a class="help-icon" title="{$elem.__message->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__message->getRenderTemplate() field=$elem.__message}</td>
                                </tr>
                                                            
                        
                    </table>
                            </div>
        </form>
    </div>