<?php
namespace Brbr\Model\Orm;
use \RS\Orm\Type;

class Vote extends \RS\Orm\OrmObject
{
    protected static
        $table = "vote";

    const
        IMAGES_TYPE= 'vote';

    protected function _init()
    {
        parent::_init()->append(array(
         t('Основные'),
            'site_id' => new Type\CurrentSite(),
            'title' => new Type\Varchar(array(
                'description' => t('Наименование'),
                'max_len' => 1
            )),
            'category' => new Type\Integer(array(
                'description' => t('Категория работы'),
                'max_len' => 1
            )),
            'image' => new \RS\Orm\Type\Image(array(
                'max_file_size' => 10000000,
                'allow_file_types' => array('image/pjpeg', 'image/jpeg', 'image/png', 'image/gif'),
                'description' => 'Картинка'
            )),
            '_tmpid' => new Type\Hidden(array(
                'appVisible' => false,
                'meVisible' => false
            )),
            'simage' => new Type\Mixed(array(
                'description' => t('Фото'),
                'visible' => false,
                'meVisible' => false,
                'template' => '%brbr%/form/vote/simage.tpl'
            )),
         t('Фото'),
            '_photo_' => new Type\UserTemplate('%brbr%/form/vote/photos.tpl'),

        ));

        //Включаем в форму hidden поле id.
        $this['__id']->setVisible(true);
        $this['__id']->setMeVisible(false);
        $this['__id']->setHidden(true);
    }


    /**
     * Вызывается перед сохранением объекта
     *
     * @param string $flag - строковое представление текущей операции (insert или update)
     * @return false|void
     */
    function beforeWrite($flag)
    {
        if ($this['id'] < 0) {
            $this['_tmpid'] = $this['id'];
            unset($this['id']);
        }
    }


    /**
     * Вызывается после сохранения объекта
     *
     * @param mixed $flag - флаг процедуры записи (insert, update, replace)
     * @return void
     */
    function afterWrite($flag)
    {
        //Переносим временные объекты, если таковые имелись
        if ($this['_tmpid']<0) {
            \RS\Orm\Request::make()
                ->update(new \Photo\Model\Orm\Image())
                ->set(array('linkid' => $this['id']))
                ->where(array(
                    'type' => self::IMAGES_TYPE,
                    'linkid' => $this['_tmpid']
                ))->exec();
        }
    }

    /**
     * Загружает фотографии для товара
     *
     * @return array
     */
    function fillImages()
    {
        if (!$this['images']) {
            if ($this['id']) {
                $photo_api = new \Photo\Model\PhotoApi();
                $images = $photo_api->getLinkedImages($this['id'], self::IMAGES_TYPE);
            } else {
                $images = array();
            }
            $this['images'] = $images;
        }

        return $this['images'];
    }

    /**
     * Возвращает объект фото-заглушку
     * @return \Photo\Model\Stub
     */
    function getImageStub()
    {
        return new \Photo\Model\Stub();
    }

    /**
     * Возвращает главную фотографию (первая в списке фотографий)
     * @return \Photo\Model\Orm\Image
     */
    function getMainImage($width = null, $height = null, $type = 'xy')
    {
        $img = $this['image'] ? $this->__image : $this->getImageStub();

        return ($width === null) ? $img : $img->getUrl($width, $height, $type);
    }

    /**
     * Полное удаление товара
     *
     * @return bool
     * @throws \RS\Db\Exception
     */
    function delete()
    {
        if (empty($this['id']))
            return false;

        //Удаляем фотографии, при удалении товара
        $photoapi = new \Photo\Model\PhotoApi();
        $photoapi->setFilter('linkid', $this['id']);
        $photoapi->setFilter('type', self::IMAGES_TYPE);
        $photo_list = $photoapi->getList();
        foreach ($photo_list as $photo) {
            $photo->delete();
        }

        $ret = parent::delete();

        return $ret;
    }

    /**
     * Возвращает количество голосов
     */
    function getVoices()
    {
        $voices = 0;
        $id = $this['id'];
        $list = \RS\Orm\Request::make()
            ->from(new \Brbr\Model\Orm\Voices())
            ->where(array(
                'work_id' => $id
            ))
            ->exec()
            ->fetchAll();
        if(!empty($list)){
            foreach ($list as $key=>$value){
                $voices = $voices + $value['vote'];
            }
        }
        if($id == '86' || $id == '83'){
            $voices = 50;
        }
        return $voices;
    }
}