<?php
namespace Brbr\Model\Orm;
use \RS\Orm\Type;

class Voices extends \RS\Orm\OrmObject
{
    protected static
        $table = "voices";

    protected function _init()
    {
        parent::_init()->append(array(
         t('Основные'),
            'site_id' => new Type\CurrentSite(),
            'session' => new Type\Varchar(array(
                'description' => t('Наименование'),
                'max_len' => 255
            )),
            'category' => new Type\Integer(array(
                'description' => t('Категория работы'),
                'max_len' => 1
            )),
            'work_id' => new Type\Integer(array(
                'description' => t('Id работы'),
                'max_len' => 1
            )),
            'user_ip' => new Type\Varchar(array(
                'description' => t('ip проголосовавшего пользователя'),
                'max_len' => 255
            )),
            'vote' => new Type\Integer(array(
                'description' => t('Голос'),
                'max_len' => 1
            )),

        ));
    }

}