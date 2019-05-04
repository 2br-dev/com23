<form method="POST" action="{$router->getUrl('users-front-register')}" class="authorization register formStyle">
    <input type="hidden" name="referer" value="{$referer}">
    {$this_controller->myBlockIdInput()}
    <h1 data-dialog-options='{ "width": "755" }'>Регистрация пользователя</h1>
        {if count($user->getNonFormErrors())>0}
            <div class="pageError">
                {foreach $user->getNonFormErrors() as $item}
                <p>{$item}</p>
                {/foreach}
            </div>
        {/if}
        <div class="userType">
            <input type="radio" id="ut_user" name="is_company" value="0" {if !$user.is_company}checked{/if}><label for="ut_user">Частное лицо</label>
            <input type="radio" id="ut_company" name="is_company" value="1" {if $user.is_company}checked{/if}><label for="ut_company">Компания</label>
        </div>        
        <div class="forms">                        
        <div class="oh {if $user.is_company} thiscompany{/if}" id="fieldsBlock">
            <div class="half fleft">
                <div class="companyFields">
                    <div class="formLine">
                        <label class="fieldName">Название организации</label>
                        {$user->getPropertyView('company')}
                    </div>                            
                </div>
                <div class="formLine">
                    <label class="fieldName">Имя</label>
                    {$user->getPropertyView('name')}
                </div>            
                <div class="formLine">
                    <label class="fieldName">Фамилия</label>
                    {$user->getPropertyView('surname')}
                </div>             
                <div class="formLine">
                    <label class="fieldName">Отчество</label>
                    {$user->getPropertyView('midname')}
                </div>                                
                <div class="formLine">
                    <label class="fieldName">Телефон</label>
                    {$user->getPropertyView('phone')}
                </div>                        
                {if $user.__captcha->isEnabled()}
                <div class="formLine captcha">
                    <label class="fieldName">&nbsp;</label>
                    <div class="alignLeft">
                        {$user->getPropertyView('captcha')}
                        <br><span class="fieldName">Защитный код</span>
                    </div>
                </div>               
                {/if}
            </div>
            <div class="half fright">
                <div class="companyFields">
                    <div class="formLine">
                        <label class="fieldName">ИНН</label>
                        {$user->getPropertyView('company_inn')}
                    </div>
                    <div class="formLine">
                        <label class="fieldName">ОГРН/ОГРНИП</label>
                        {$user->getPropertyView('company_ogrn')}
                    </div>                                 
                </div>                        
                <div class="formLine">
                    <label class="fieldName">E-mail</label>
                    {$user->getPropertyView('e_mail')}
                </div>
                <div class="formLine">
                    <label class="fieldName">Пароль</label>
                    <input type="password" name="openpass" {if count($user->getErrorsByForm('openpass'))}class="has-error"{/if}>
                    <div class="formFieldError">{$user->getErrorsByForm('openpass', ',')}</div>                    
                </div>            
                <div class="formLine">
                    <label class="fieldName">Повтор пароля</label>
                    <input type="password" name="openpass_confirm">
                </div>
                {if $conf_userfields->notEmpty()}
                    {foreach $conf_userfields->getStructure() as $fld}
                    <div class="formLine">
                    <label class="fieldName">{$fld.title}</label>
                        {$conf_userfields->getForm($fld.alias)}
                        {$errname=$conf_userfields->getErrorForm($fld.alias)}
                        {$error=$user->getErrorsByForm($errname, ', ')}
                        {if !empty($error)}
                            <span class="formFieldError">{$error}</span>
                        {/if}
                    </div>
                    {/foreach}
                {/if}              
            </div>
        </div>
        <div class="personal">
            <input type="checkbox" id="personal_chk"><label for="personal_chk">Нажимая кнопку «Зарегистрироваться», я принимаю условия <a href="http://com23.ru/o-kompanii/polzovatelskoe-soglashenie/" target="_blank">Пользовательского соглашения</a> и даю своё <a href="http://com23.ru/o-kompanii/obrabotka-personalnyh-dannyh/#sogl" target="_blank">согласие на обработку  персональных данных</a> ООО "Акватория" и ИП Картамышева А.А., в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных <a href="http://com23.ru/o-kompanii/politika-konfedencialnosti/" target="_blank">Политикой конфиденциальности</a> и <a href="http://com23.ru/o-kompanii/obrabotka-personalnyh-dannyh/#polit" target="_blank">Политикой в отношении обработки персональных данных</a></label>
            <p class="personal_notice">Для продолжения Вы должны принять условия Пользовательского соглашения</p>
        </div>
        <div class="buttons cboth">
            <input type="submit" value="Зарегистрироваться" disabled class="btn_disabled">
        </div> 
    </div>   
    
    <script type="text/javascript">
        $(function() {
            $('.userType input').click(function() {
                $('#fieldsBlock').toggleClass('thiscompany', $(this).val() == 1);
                if ($(this).closest('#colorbox')) $.colorbox.resize();
            });

            $('#personal_chk').click(function(){
                if ($(this).prop('checked')){
                    $('form.register input[type="submit"]').removeAttr('disabled');
                    $('form.register input[type="submit"]').removeClass('btn_disabled');
                    $('.personal_notice').css('display', 'none');
                }
                else{
                    $('form.register input[type="submit"]').attr('disabled', 'disabled');
                    $('form.register input[type="submit"]').addClass('btn_disabled');
                    $('.personal_notice').css('display', 'block');
                }
            });

            $('input[name="phone"]').mask("+7 (999) 999-9999");   
            
        });        
    </script>    
</form>