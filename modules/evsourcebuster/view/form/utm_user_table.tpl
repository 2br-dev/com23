{static_call var=utm_decoded callback=['\evSourceBuster\Model\Utm','getSourceAuto'] params=[$elem.source_info]}
 {$color='#c0b700'}
{if $utm_decoded.utm.src == 'utm'}
   {$color='#d77600'}
{elseif $utm_decoded.utm.src == 'referral'}
   {$color='#925cd2'}
{elseif $utm_decoded.utm.src == 'organic'}
   {$color='#ff2d39'}
{/if}

<div class='orderStatusColor' style='background: {$color};'></div>

{$utm_decoded.name} {$utm_decoded.utm.src}      