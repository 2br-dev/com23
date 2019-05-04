<?php
namespace Eridan\Controller\Block;

class NextDeliveryDate extends \RS\Controller\Block
{
    protected static
        $controller_title = 'Следующая дата доставки',
        $controller_description = 'Отображает дату';
    
    function actionIndex()
    {
       $next_date = date('m.d.Y', strtotime('Next Thursday'));
       
       $this->view->assign(array(
          'next_date' => $next_date
       ));
       
       return $this->result->setTemplate('blocks/nextdeliverydate/next_date.tpl');
    }    
}
?>
