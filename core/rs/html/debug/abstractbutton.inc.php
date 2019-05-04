<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/

namespace RS\Html\Debug;

/**
* Базовый класс всех значков в режиме отладки
*/
abstract class AbstractButton implements \RS\Html\ElementInterface
{
    protected 
        $attr = array('class' => 'icon'),
        $href = '',
        $icon_url = '',
        $title = '',
        $template = 'system/debug/icon_def.tpl',
        $uniq_group;
    
    function getView()
    {
        $html = new \RS\View\Engine();
        $html->assign(array(
            'attr' => $this->attr,
            'href' => $this->href,
            'icon_url' => $this->icon_url,
            'title' => $this->title,
        ));
        return $html->fetch($this->template);
    }
    
    /**
    * Устанавливает идентификатор группы, к которой относится инструмент
    */
    function setUniq($uniq_group)
    {
        $this->uniq_group = $uniq_group;
    }
}

