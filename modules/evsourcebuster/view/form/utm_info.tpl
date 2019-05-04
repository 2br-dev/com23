
{$color='#c0b700'}
{if $utm.utm.typ == 'utm'}
   {$color='#d77600'}
{elseif $utm.utm.typ == 'referral'}
   {$color='#925cd2'}
{elseif $utm.utm.typ == 'organic'}
   {$color='#ff2d39'}

{/if}

{if $utm.utm.typ != ''}
<div class='orderStatusColor' style='background: {$color};'></div>
{$utm.name} {$utm.utm.src}
    
{/if}