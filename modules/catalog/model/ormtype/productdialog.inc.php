<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Catalog\Model\OrmType;

class ProductDialog extends \RS\Orm\Type\ArrayList
{
    protected
        $form_template = '%catalog%/form/ormtype/product_dialog.tpl',
        $hide_group_checkbox = false,
        $hide_product_checkbox = false;
    
    public function getProductDialog()
    {
        $product_dialog = new \Catalog\Model\ProductDialog($this->name, $this->hide_group_checkbox, $this->value, $this->hide_product_checkbox);
        
        return $product_dialog->getHtml();
    }
}
