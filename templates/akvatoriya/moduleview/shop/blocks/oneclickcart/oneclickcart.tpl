{if $success}
    <p class="oneClickCartSuccess">Спасибо!<br/> В ближайшее время с Вами свяжется наш менеджер.</p>
{else}
    {assign var=catalog_config value=ConfigLoader::byModule('catalog')} 
    <div class="oneClickCart">
        <div id="toggleOneClickCart" class="oneClickCartWrapper" style="display:none;">
            <div class="togglePhoneWrapper formStyle "> 
                <form class="oneClickCartForm forms" action="{$router->getUrl('shop-block-oneclickcart')}">
                    {$this_controller->myBlockIdInput()}
                    <div class="center">
                        {if !empty($errors)}
                            <p class="pageError">
                            {foreach $errors as $error}
                                {$error}<br>
                            {/foreach}
                            </p>
                        {/if}                    
                        <div class="formLine">
                            <label class="fielName">Ваше имя</label><br>
                            <input type="text" value="{$name}" size="30" maxlength="100" name="name" class="inp"/>
                        </div>
                        <div class="formLine">
                            <label class="fielName">Ваш телефон</label><br>
                            <input type="text" value="{$phone}" size="30" maxlength="100" name="phone" class="inp"/>
                        </div>
                        <div class="personal">
				            <input type="checkbox" id="personal_chk"><label for="personal_chk">Нажимая кнопку «Отправить», я принимаю условия <a href="http://com23.ru/o-kompanii/polzovatelskoe-soglashenie/" target="_blank">Пользовательского соглашения</a> и даю своё <a href="http://com23.ru/o-kompanii/obrabotka-personalnyh-dannyh/#sogl" target="_blank">согласие на обработку  персональных данных</a> ООО "Акватория" и ИП Картамышева А.А., в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных <a href="http://com23.ru/o-kompanii/politika-konfedencialnosti/" target="_blank">Политикой конфиденциальности</a> и <a href="http://com23.ru/o-kompanii/obrabotka-personalnyh-dannyh/#polit" target="_blank">Политикой в отношении обработки персональных данных</a></label>
				            <p class="personal_notice">Для продолжения Вы должны принять условия Пользовательского соглашения</p>
				        </div>
                        {foreach from=$oneclick_userfields->getStructure() item=fld}
                            {if $fld.title != 'Количество'}
                                <div class="formLine">
                                    <label class="fielName">{$fld.title}</label><br>
                                    {$oneclick_userfields->getForm($fld.alias)}
                                </div>
                            {/if}
                        {/foreach}
                        {if !$is_auth && $use_captcha && ModuleManager::staticModuleEnabled('kaptcha')}
                           <div class="email-captcha">
                               <label class="hidden-xs">{t}Введите код, указанный на картинке{/t}</label>
                               <img height="42" width="100" src="{$router->getUrl('kaptcha', ['rand' => rand(1, 9999999)])}" alt=""/>
                               <input type="text" name="kaptcha" class="kaptcha">
                           </div>
                        {/if}
                        <input type="submit" value="{t}Отправить{/t}" class="btn_disabled" disabled style="margin-top: 25px;"/>
                    </div>                   
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){ 
            $.oneClickCart('bindChanges');
            $('#personal_chk').click(function(){
                if ($(this).prop('checked')){
                    $('form.oneClickCartForm input[type="submit"]').removeAttr('disabled');
                    $('form.oneClickCartForm input[type="submit"]').removeClass('btn_disabled');
                    $('.personal_notice').css('display', 'none');
                }
                else{
                    $('form.oneClickCartForm input[type="submit"]').attr('disabled', 'disabled');
                    $('form.oneClickCartForm input[type="submit"]').addClass('btn_disabled');
                    $('.personal_notice').css('display', 'block');
                }
            });
        });
    </script>
{/if}
