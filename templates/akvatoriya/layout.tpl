{* Основной шаблон *}
{strip}
{addmeta name="viewport" content="width=device-width, initial-scale=1.0"}
{addmeta name="google-site-verification" content="aFLVL57LiMxRk7xCjgxY3boct42-lKHynPE2XpL1DCo"}
{addcss file="/rss-news/" basepath="root" rel="alternate" type="application/rss+xml" title="t('Новости')"}
{addcss file="reset.css"}
{addcss file="style.css?v=2"}

{addcss file="hover.css"}
{addcss file="style768.css"}
{addcss file="style640.css"}
{addcss file="style480.css"}
{addcss file="style320.css"}
{addcss file="simplelightbox.min.css"}
{addjs file="simple-lightbox.min.js"}
{addjs file="jquery.tinycarousel.js"}

{addcss file="slick.css"}
{addjs file="slick.js"}

{addcss file="colorbox.css"}
{addjs file="html5shiv.js" unshift=true header=true}
{addjs file="jquery.min.js" name="jquery" basepath="common" unshift=true}
{addjs file="jquery.autocomplete.js"}
{addjs file="jquery.activetabs.js"}
{addjs file="jquery.form.js" basepath="common"}
{addjs file="jquery.cookie.js" basepath="common"}
{addjs file="jquery.switcher.js"}
{addjs file="jquery.ajaxpagination.js"}
{addjs file="jquery.colorbox.js"}
{addjs file="jquery.scrollTo-min.js"}
{addjs file="modernizr.touch.js"}
{addjs file="modalEffects.js"}
{addjs file="cleave.min.js"}

{addjs file="https://api-maps.yandex.ru/2.1/?lang=ru_RU" basepath="root"}

{addjs file="maskedinput.js"}

{addjs file="classie.js"}
{addjs file="jquery.cookie.js"}

{addcss file="https://com23.ru/favicon.ico" basepath="root" rel="icon" type="image/ico"}


{addjs file="common.js"}
{addjs file="theme.js"}
{addmeta http-equiv="X-UA-Compatible" content="IE=Edge" unshift=true}
{assign var=shop_config value=ConfigLoader::byModule('shop')}
{if $shop_config===false}{$app->setBodyClass('shopBase', true)}{/if}
{if $shop_config}
    {addjs file="%shop%/jquery.oneclickcart.js"}
{/if}


{$app->setDoctype('HTML')}
{/strip}
{$app->blocks->renderLayout()}

{* Подключаем файл scripts.tpl, если он существует в папке темы. В данном файле 
рекомендуется добавлять JavaScript код, который должен присутствовать на всех страницах сайта *}
{tryinclude file="%THEME%/scripts.tpl"}