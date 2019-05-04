<?php
namespace SberbankACPayment\Model\Orm;

class Transaction extends \RS\Orm\AbstractObject
{
    protected static
        $table = "sberbankac_transaction"; //Имя таблицы в БД
    // Инициализирует свойства ORM-объектов
    // @return \RS\Orm\PropertyIterator
    protected function _init()
    {
        return $this->getPropertyIterator()->append(array(
            'transaction_id' => new \RS\Orm\Type\Integer(array(
                'primaryKey' => true,
                'autoincrement' => false
            )),
            'order_id' => new \RS\Orm\Type\Integer(array(
                'index' => true,
            )),
            'sberbank_id' => new \RS\Orm\Type\Varchar(array(
                'maxLength' => '40',
                'description' => 'Заказ в Сбербанке',
                'index' => true
            )),
            'status' => new \RS\Orm\Type\Integer(array(
                'index' => true,
            )),
        ));
    }

    protected function _initDefaults()
    {
        $this['status'] = 0;
    }
}