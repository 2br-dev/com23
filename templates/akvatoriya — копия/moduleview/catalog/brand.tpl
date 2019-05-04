{addjs file="jquery.changeoffer.js"}
{addjs file="jcarousel/jquery.jcarousel.min.js"}
{addjs file="list_product.js"}
{assign var=shop_config value=ConfigLoader::byModule('shop')}
{assign var=check_quantity value=$shop_config->check_quantity}

<div class="brandPage">
    <article class="description">    
       {if $brand.image} 
         <img src="{$brand->__image->getUrl(250,250,'xy')}" class="mainImage"/> 
       {/if}
       {$brand.description}
    </article>
    {if !empty($dirs)}
        {if count($dirs) < 6}
        {elseif count($dirs) < 15}
           {$widthClass="col2"}
        {else}
            {$widthClass="col3"}
        {/if}
    
        <div class="brandDirs">
            <h3>Категории товаров {$brand.title}</h3>
            <ul class="cats {$widthClass}">
             {foreach $dirs as $dir}
                <li>
                    <a href="{$router->getUrl('catalog-front-listproducts',['category'=>$dir.alias,'bfilter'=> ["brand" => [$brand.id]]])}">{$dir.name}</a> <sup>({$dir.brands_cnt})</sup>
                </li>
             {/foreach}
            </ul>
        </div>
    {/if}
    
    {if !empty($products)}
          <div class="tabs brandProducts">
                <ul class="tabList">
                    <li data-href=".frame1" class="act"><a>Актуальные товары {$brand.title}</a></li>
                </ul>
                <div class="tab act frame1">
                     <ul class="products">
                        {foreach $products as $product}
                            <li {$product->getDebugAttributes()} data-id="{$product.id}">
                                <a href="{$product->getUrl()}" class="image">{if $product->inDir('new')}<i class="new"></i>{/if}<img src="{$product->getMainImage(188,258)}"></a>
                                <a href="{$product->getUrl()}" class="title">{$product.title}</a>
                                <p class="price">{$product->getCost()} {$product->getCurrency()} 
                                    {$last_price=$product->getCost('Зачеркнутая цена')}
                                    {if $last_price>0}<span class="last">{$last_price} {$product->getCurrency()}</span>{/if}</p>
                                <div class="hoverBlock">
                                    <div class="back"></div>
                                    <div class="main">
                                        {if $shop_config}
                                            {if $product->shouldReserve()}
                                                <a href="{$router->getUrl('shop-front-reservation', ["product_id" => $product.id])}" class="button reserve inDialog">Заказать</a>
                                            {else}        
                                                {if $check_quantity && $product.num<1}
                                                    <span class="noAvaible">Нет в наличии</span>
                                                {else}
                                                    {if $product->isOffersUse() || $product->isMultiOffersUse()}
                                                        <span data-href="{$router->getUrl('shop-front-multioffers', ["product_id" => $product.id])}" class="button showMultiOffers inDialog noShowCart">В корзину</span>
                                                    {else}
                                                        <a href="{$router->getUrl('shop-front-cartpage', ["add" => $product.id])}" class="button addToCart noShowCart" data-add-text="Добавлено">В корзину</a>
                                                    {/if}                                                            
                                                {/if}
                                            {/if}
                                        {/if}                            
                                        <a class="compare{if $product->inCompareList()} inCompare{/if}"><span>К сравнению</span><span class="already">Добавлено</span></a>
                                    </div>
                                </div>                        
                            </li>                   
                        {/foreach}
                    </ul>
                </div>
          </div>
    {/if}   
</div>