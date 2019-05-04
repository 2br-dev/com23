{addjs file="jquery.changeoffer.js"}
{$shop_config=ConfigLoader::byModule('shop')}
{$check_quantity=$shop_config.check_quantity}
{assign var=catalog_config value=$this_controller->getModuleConfig()}

{if $no_query_error}
<div class="noQuery">
    Не задан поисковый запрос
</div>      
{else}
<div id="products" {if $shop_config}class="shopVersion"{/if}>
    {if !empty($query)}
        <h1>Результаты поиска</h1>
    {else}
        <h1>{$category.name}</h1>
		{if $category.name == 'Вода'}
		<div class="voda-anapa"><a href="/catalog/voda-v-anape/">Ассортимент и цены для Анапы</a></div>
		{/if}
		{if $category.name == 'Вода в анапе'}
		<div class="voda-anapa"><a href="/catalog/voda/">Ассортимент и цены для Краснодара</a></div>
		{/if}
    {/if}
    {if $category.description}<article class="categoryDescription">{$category.description}</article>{/if}
    
	
    {if count($list)}
    <div class="sortLine">
		{if $category.name == 'Вода'}
		<div class="text-forceo">
			<p>Единая служба доставки питьевой воды уже более 10 лет доставляет чистую питьевую воды Вам домой или в офис. Продажа питьевой воды в 19 л. бутылях - наш основной профиль, именно поэтому мы предлагаем самый широкий выбор чистой питьевой воды и самый качественный сервис по ее доставке в Краснодаре и Анапе. 
			Вы всегда можете купить чистую питьевую воды в сети магазинов "Мир воды" в Краснодаре или Анапе или в нашем интернет-магазине. Доставка воды осуществляется бесплатно и в день заказа (за исключением отдаленных районов).
			</p>
		</div>
		{/if}
		{if $category.name == 'Кулеры'}
		<div class="text-forceo">
			<p>Компания "Единая служба доставки питьевой воды" уже много лет осуществляет продажу кулеров для питьевой воды в Краснодаре и Анапе. Широкий ассортимент и постоянное наличие позволит купить именно тот кулер, который подходит Вам. Наши менеджеры и консультанты всегда помогут определиться Вам с выбором. Вы всегда можете купить любой кулер в Краснодаре или Анапе в сети магазинов "Мир воды" или в нашем интернет-магазине.
			</p>
		</div>
		{/if}
		{if $category.name == 'Фильтры'}
		<div class="text-forceo">
			<p>Фильтры для очистки воды стали неотъемлемой частью любой квартиры или частного дома. Пить водопроводную воду без предварительной очистки небезопасно. Именно поэтому, компания "Единая служба доставки питьевой воды" предлагает самый широкий ассортимент фильтров для очистки воды. Постоянное наличие сменных картриджей позволит Вам всегда иметь чистую питьевую воду у себя дома или на даче. Купить фильтр для очистки воды вы всегда сможете в сети магазинов "Мир воды" в Краснодаре или Анапе или в нашем интернет-магазине.
			</p>
		</div>
		{/if}
		{if $category.name == 'Сопутствующие товары'}
		<div class="text-attention">
			<p>Доставка товаров из данной категории осуществляется только с поставкой воды.</p>
		</div>
		{/if}
        <div class="viewAs">
            <a href="{urlmake viewAs=table}" class="viewAs table{if $view_as == 'table'} act{/if}"></a>
            <a href="{urlmake viewAs=blocks}" class="viewAs blocks{if $view_as == 'blocks'} act{/if}"></a>                
        </div> 
		<div class="cb"></div>
    </div>    
    
    {*{if count($sub_dirs)}{assign var=one_dir value=reset($sub_dirs)}{/if}
    {if empty($query) || (count($sub_dirs) && $dir_id != $one_dir.id)}
    <nav class="subCategory">
        {foreach $sub_dirs as $item}
        <a href="{urlmake category=$item._alias p=null f=null bfilter=null}">{$item.name}</a>
        {/foreach}
    </nav>
    {/if}*}
    
    {if $view_as == 'blocks'}
        {include file="%catalog%/products_as_blocks.tpl"}
    {else}
		{include file="%catalog%/products_as_table.tpl"}

    {/if}
    {include file="%THEME%/paginator.tpl"}
    
    {else}    
        <div class="noProducts">
            {if !empty($query)}
            Извините, ничего не найдено
            {else}
            В данной категории нет ни одного товара
            {/if}
        </div>
    {/if}

</div>
{/if}