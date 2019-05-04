{* Список категорий из 2-х уровней*}
{if $dirlist}
<nav class="category">
    <!--<div class="new-year-menu-left">
        <img src="{$THEME_IMG}/1.png">
    </div>
    <div class="new-year-menu-right">
        <img src="{$THEME_IMG}/2.png">
    </div>-->
    <div class="wrap-category">
        {foreach $dirlist as $dir}
        <div class="{if !empty($dir.child)} node{/if} first-ur{if $dir.fields.name == 'Товары для животных'} dog{/if}" {$dir.fields->getDebugAttributes()}>
            <a href="{$dir.fields->getUrl()}" class="wobble-vertical">{$dir.fields.name}</a><i></i>            
        </div>
        {/foreach}
		<div class="first-ur">
			<a class="wobble-vertical" href="/dostavka/">Доставка</a>
		</div>
    </div>
    <div class="wrap-categoryMobile">
        <a class="categoryMobile__link" id="catalogMobile">Каталог</a>
    </div>    
</nav>

<div class="categoryMobile">
    {foreach $dirlist as $dir}
    <div class="{if !empty($dir.child)} node{/if} first-ur{if $dir.fields.name == 'Товары для животных'} dog{/if}" {$dir.fields->getDebugAttributes()}>
        <a href="{$dir.fields->getUrl()}" class="wobble-vertical">{$dir.fields.name}</a><i></i>        
    </div>
    {/foreach}
    <a class="close_categoryMobile" id="close_categoryMobile">Х</a>
</div>

{literal}
<script>
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