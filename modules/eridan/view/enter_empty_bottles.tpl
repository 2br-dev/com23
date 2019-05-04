{if !$success}
    <h1 data-dialog-options='{ "width": "460" }'>Количество бутылок</h1>
    <form action="{$router->getUrl('eridan-front-enteremptybottles')}" class="authorization formStyle" method="POST">
        <div class="forms">
        <p>Введите количество Ваших бутылок</p>
            <div class="center">
                <div class="formLine">
                    <input type="text" name="bottles" value="0" class="inp"/>
                </div>
                <div class="oh">
                    <div class="fleft">
                        <input type="submit" value="Отправить"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
{else}
    <script>
        location.reload(true);
        if ($.colorbox){
            $.colorbox.close();
        }
    </script>
{/if}