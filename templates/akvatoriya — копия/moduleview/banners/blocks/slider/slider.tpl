{addjs file="{$mod_js}jquery.photoslider.js" basepath="root"}
{if $zone}
    {$banners=$zone->getBanners()}
    <!--<div class="new-year" style="text-align: center; margin-bottom: 15px;"><img src="{$THEME_IMG}/8_march_2018_com23.jpg" style="max-width: 100%;"></div>-->
    <!--<div class="new-year" style="text-align: center; margin-bottom: 15px;"><a href="http://com23.ru/o-kompanii/komanda/"><img style="max-width: 100%;" src="{$THEME_IMG}/vakansii.jpg"></a></div>-->
    <div class="bannerSlider">
	<!--<div class="new-year" style="text-align: center; margin-bottom: 15px;"><img src="{$THEME_IMG}/9_may_2017.png"></div>-->

        <ul class="items">
            {foreach $banners as $banner}
            <li {$banner->getDebugAttributes()} class="item{if $banner@first} act{/if}">
                {if $banner.link}<a href="{$banner.link}"{if $banner.targetblank}target="_blank"{/if}>{/if} 
                <img src="{$banner->getBannerUrl($zone.width, $zone.height, 'axy')}" alt="{$banner.title}">
                {if $banner.link}</a>{/if}
            </li>
            {/foreach}            
        </ul>
        {if count($banners)>1}
        <div class="pages">
            <span class="center">
                <span class="back"></span>
                <span class="list">        
                {foreach $banners as $banner}
                    <a {if $banner@first}class="act"{/if}>{$banner@iteration}</a>
                {/foreach}
                </span>
            </span>
        </div>
        {/if}
        
        <!--<div class="leaves-left">
            <img src="{$THEME_IMG}/leaves-left-banner.jpg">
        </div>
        <div class="leaves-right">
            <img src="{$THEME_IMG}/leaves-right-banner.jpg">
        </div>-->

    </div>
	<div class="slider-shadow"><img src="{$THEME_IMG}/slider-shadow.png"/></div>
    <!--<div class="new-year" style="text-align: center; margin-top: 60px; width: 100%;"><img src="{$THEME_IMG}/new_year_2018.jpg" style="max-width: 100%;"></div>-->
{else}
    {include file="%THEME%/block_stub.tpl"  class="blockSlider" do=[
        [
            'title' => t("Добавьте зону с баннерами"),
            'href' => {adminUrl do=false mod_controller="banners-ctrl"}
        ],
        [
            'title' => t("Настройте блок"),
            'href' => {$this_controller->getSettingUrl()},
            'class' => 'crud-add'
        ]
    ]}
{/if}