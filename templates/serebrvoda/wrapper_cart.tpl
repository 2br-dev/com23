{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
    <div class="box">
        {moduleinsert name="\Main\Controller\Block\Breadcrumbs"}
        {$app->blocks->getMainContent()}
    </div>

    <!-- Google Code for &#1079;&#1072;&#1082;&#1072;&#1079; Conversion Page -->
	<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 1037659089;
	var google_conversion_language = "en";
	var google_conversion_format = "3";
	var google_conversion_color = "ffffff";
	var google_conversion_label = "u4qSCMTxtF4Q0dfl7gM";
	var google_remarketing_only = false;
	/* ]]> */
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1037659089/?label=u4qSCMTxtF4Q0dfl7gM&guid=ON&script=0"/>
	</div>
	</noscript>
    
{/block}
{block name="fixedCart"}{/block} {* Исключаем плавающую корзину *}