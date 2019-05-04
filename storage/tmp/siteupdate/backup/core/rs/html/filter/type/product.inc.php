<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace RS\Html\Filter\Type;

/**
 * Фильтр по пользователю. Отображается в виде поля c autocomplete.
 */
class Product extends AbstractType
{
    public
        $tpl = 'system/admin/html_elements/filter/type/product.tpl';

    protected
        $request_url;

    function __construct($key, $title, $options = array())
    {
        $this->attr = array(
            'class' => 'w150'
        );
        parent::__construct($key, $title, $options);
        @$this->attr['class'] .= ' object-select';
    }

    /**
     * Возвращает URL для поиска пользователя
     *
     * @return string
     */
    function getRequestUrl()
    {
        return $this->request_url ?: \RS\Router\Manager::obj()->getAdminUrl('ajaxProduct', null, 'catalog-ajaxlist');
    }

    /**
     * Устанавливает URL для поиска пользователя
     *
     * @param string $url
     * @return User
     */
    function setRequestUrl($url)
    {
        $this->request_url = $url;
        return $this;
    }
}
?>
