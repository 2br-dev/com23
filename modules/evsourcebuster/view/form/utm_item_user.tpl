{static_call var=utm callback=['\evSourceBuster\Model\Utm','getSourceAuto'] params=[$elem.source_info]}

{include file='%evsourcebuster%/form/utm_info.tpl' utm=$utm.first} <br/>
{include file='%evsourcebuster%/form/utm_info.tpl' utm=$utm.current}

