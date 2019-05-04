<div class="feedbkForm">
   {if $success}
       <div class="formResult success"> 
          {$form.successMessage|default:"Благодарим Вас за обращение к нам. Мы ответим вам при первой же возможности."}
       </div>
   {else}

   {if $form.id} 
       <form method="POST" enctype="multipart/form-data" action="{urlmake}" class="formStyle feedback_form"> 
           {$this_controller->myBlockIdInput()}
           <input type="hidden" name="form_id" value="{$form.id}"/>
           {assign var=fields value=$form->getFields()} 
           <h1>{$form.title}</h1>
            
           {if $error_fields}
               <div class="pageError"> 
               {foreach from=$error_fields item=error_field}
                   {foreach from=$error_field item=error}
                        <p>{$error}</p>
                   {/foreach}
               {/foreach}
               </div>
           {/if}
              
           <table class="formTable">
               <tbody>
                   {foreach from=$fields item=item key=key} 
                       <tr class="feedbkRow">
                            
                           <td class="title key">
                             {$item.title}
                             {if $item.required}
                                  <span class="required">*</span>
                             {/if}
                           </td> 
                           <td class="fieldVals value">
                               {$item->getFieldForm()}
                               {if $item.hint}
                                   <div class="help">
                                       {$item.hint}
                                   </div>
                               {/if}
                           </td>      
                       </tr>
                   {/foreach}
               </tbody>
           </table>
           <div class="reqBox">
              <span class="required">*</span> - Поля обязательные для заполнения
           </div>

           <div class="personal">
	            <input type="checkbox" id="personal_chk"><label for="personal_chk">Нажимая кнопку «Зарегистрироваться», я принимаю условия <a href="http://com23.ru/o-kompanii/polzovatelskoe-soglashenie/" target="_blank">Пользовательского соглашения</a> и даю своё <a href="http://com23.ru/o-kompanii/obrabotka-personalnyh-dannyh/#sogl" target="_blank">согласие на обработку  персональных данных</a> ООО "Акватория" и ИП Картамышева А.А., в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных <a href="http://com23.ru/o-kompanii/politika-konfedencialnosti/" target="_blank">Политикой конфиденциальности</a> и <a href="http://com23.ru/o-kompanii/obrabotka-personalnyh-dannyh/#polit" target="_blank">Политикой в отношении обработки персональных данных</a></label>
	            <p class="personal_notice">Для продолжения Вы должны принять условия Пользовательского соглашения</p>
	        </div>

           <div>
              <input type="submit" class="formSave btn_disabled" value="Отправить" disabled/>
           </div>

           <script type="text/javascript">
	        $(function() {	            
	            $('#personal_chk').click(function(){
	                if ($(this).prop('checked')){
	                    $('form.feedback_form input[type="submit"]').removeAttr('disabled');
	                    $('form.feedback_form input[type="submit"]').removeClass('btn_disabled');
	                    $('.personal_notice').css('display', 'none');
	                }
	                else{
	                    $('form.feedback_form input[type="submit"]').attr('disabled', 'disabled');
	                    $('form.feedback_form input[type="submit"]').addClass('btn_disabled');
	                    $('.personal_notice').css('display', 'block');
	                }
	            });	            
	        });        
	    </script>    

       </form>
   {else}
      <p>Формы с таким id не существует. Или id указан неправильно.</p>
   {/if}
   {/if}
</div>
