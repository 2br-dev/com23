{addcss file="%statistic%/statistic.css"}
{$all_sections = [
    ['key' => 'keyindicatorsbywaves', 'title' => "{t}Ключевые показатели{/t}"],
    ['key' => 'bestsellers', 'title' => "{t}Самые продаваемые товары{/t}"],
    ['key' => 'mostprofitable', 'title' => "{t}Самые доходные товары{/t}"],
    ['key' => 'ltv', 'title' => "{t}Выручка и доход от клиентов{/t}"],
    ['key' => 'funnel', 'title' => "{t}Воронка оформления заказа{/t}"],
    ['key' => 'sources', 'title' => "{t}Источники покупателей{/t}"]
]}

<div id="updatableDashboard" class="viewport">
    <div class="rs-tabs" role="tabpanel">

        <ul class="tab-nav" role="tablist">
            {foreach $all_sections as $sec}
                <li class="{if $sec.key == $section} active{/if}">
                    <a href="{adminUrl section=$sec.key}">
                        {$sec.title}
                    </a>
                </li>
            {/foreach}
        </ul>

        <div class="tab-content">
            {if $section == 'keyindicatorsbywaves'}
                {moduleinsert name="Statistic\Controller\Admin\Block\KeyIndicatorsByWaves"}
            {/if}

            {if $section == 'keyindicators'}
                {moduleinsert name="Statistic\Controller\Admin\Block\KeyIndicators"}
            {/if}

            {if $section == 'bestsellers'}
                {moduleinsert name="\Statistic\Controller\Admin\Block\Bestsellers"}
            {/if}

            {if $section == 'mostprofitable'}
                {moduleinsert name="\Statistic\Controller\Admin\Block\MostProfitableProducts"}
            {/if}

            {if $section == 'ltv'}
                {moduleinsert name="\Statistic\Controller\Admin\Block\LifeTimeValue"}
            {/if}

            {if $section == 'funnel'}
                {moduleinsert name="Statistic\Controller\Admin\Block\SalesFunnel"}
            {/if}

            {if $section == 'sources'}
                {moduleinsert name="Statistic\Controller\Admin\Block\Sources"}
            {/if}
        </div>
    </div>
</div>


