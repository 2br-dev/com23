{* Список категорий из 2-х уровней*}
{if $dirlist}
<nav class="category">
    <div class="wrap-category">
        {foreach $dirlist as $dir}
        <div class="{if !empty($dir.child)} node{/if} first-ur{if $dir.fields.name == 'Товары для животных'} dog{/if}" {$dir.fields->getDebugAttributes()}>
            <a href="{$dir.fields->getUrl()}" class="wobble-vertical {if $dir.fields.name == 'Акции'}category__red{/if}" title="{$dir.fields.name}">{$dir.fields.name}</a><i></i>
            {if $dir.fields.name == 'Сопутствующие товары'}
                <div class="novelty">
                    <p>Новинки</p>
                </div>
            {/if}
            <!--{if !empty($dir.child)}
                {* Второй уровень *}
                <ul>
                    {foreach $dir.child as $subdir}
                    <li><a href="{$subdir.fields->getUrl()}">{$subdir.fields.name}</a>
                        {if !empty($subdir.child)}
                        {* Третий уровень *}
                        <ul>
                            {foreach $subdir.child as $subdir2}
                            <li><a href="{$subdir2.fields->getUrl()}">{$subdir2.fields.name}</a></li>
                            {/foreach}
                        </ul>
                        {/if}
                    </li>
                    {/foreach}
                </ul>
            {/if}-->
        </div>
        {/foreach}
		<div class="first-ur">
			<a class="wobble-vertical" href="/servis/" title="Сервис">Сервис</a>
		</div>
    </div>
    <div class="wrap-categoryMobile">
        <a class="categoryMobile__link" id="catalogMobile" title="Каталог">Каталог</a>
    </div>
</nav>
<div class="categoryMobile">
    {foreach $dirlist as $dir}
    <div class="{if !empty($dir.child)} node{/if} first-ur{if $dir.fields.name == 'Товары для животных'} dog{/if}" {$dir.fields->getDebugAttributes()}>
        <a href="{$dir.fields->getUrl()}" class="wobble-vertical" title="{$dir.fields.name}">{$dir.fields.name}</a><i></i>        
    </div>
    {/foreach}
    <div class="first-ur">
            <a class="wobble-vertical" href="/servis/" title="Сервис">Сервис</a>
        </div>
    <a class="close_categoryMobile" id="close_categoryMobile">Х</a>
</div>

{literal}
<script type="text/javascript">
    $(document).ready(function() {        
        $('#catalogMobile').click(function() {
            $('.categoryMobile').toggleClass('open_categoryMobile');
            $('#md_overlay').toggleClass('show_overlay');
            $('body').css("overflow", "hidden");
            //return false;
        });
        $('#close_categoryMobile').click(function(){
            $('.categoryMobile').toggleClass('open_categoryMobile');
            $('#md_overlay').toggleClass('show_overlay');
            $('body').css("overflow", "auto");
        });
    });
</script>
{/literal}
{else}
    {include file="%THEME%/block_stub.tpl"  class="blockCategory" do=[
        [
            'title' => t("Добавьте категории товаров"),
            'href' => {adminUrl do=false mod_controller="catalog-ctrl"}
        ]
    ]}
{/if}