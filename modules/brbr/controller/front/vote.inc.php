<?php
namespace Brbr\Controller\Front;

use Brbr\Model\Orm\Voices;

class Vote extends \RS\Controller\Front
{
    /**
     * @var \Brbr\Model\Api $api
     */
    public $api;

    function init()
    {
        $this->api = new \Brbr\Model\Api();
    }

    function actionIndex()
    {
        $list = $this->api->getKonkursListByCategory();

        $this->view->assign(array(
            'list' => $list
        ));

        return $this->result->setTemplate('%brbr%/konkurs.tpl');
    }

    /**
     * Голосование за работу
     */
    function actionVote()
    {
        $id = $this->request('id', TYPE_INTEGER, 0);
        $category = $this->request('category', TYPE_INTEGER, 0);
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $site_id = \RS\Site\Manager::getSiteId();
        //$session = $_COOKIE['PHPSESSID'];
        $coockie_life_time  =   60 * 60 * 24 * 30;


        if($category == 1){
            if(!isset($_COOKIE['vote_young']) || $_COOKIE['vote_young'] != 'voted') {
                setcookie('vote_young', 'voted', time() + $coockie_life_time);
            }
            else{
                return $this->result->setSuccess(false);
                die();
            }
        }

        if($category == 2){
            if(!isset($_COOKIE['vote_old']) || $_COOKIE['vote_old'] != 'voted'){
                setcookie('vote_old', 'voted', time() + $coockie_life_time);
            }
            else{
                return $this->result->setSuccess(false);
                die();
            }
        }

        $voted_ip = \RS\Orm\Request::make()
            ->from(new \Brbr\Model\Orm\Voices())
            ->where(array(
                'user_ip' => $user_ip
            ))
            ->where(array(
                'category' => $category
            ))
            ->exec()
            ->fetchAll();

        if(count($voted_ip) != 0){
            return $this->result->setSuccess(false);
            die();
        }

        if ($id == '83' || $id == '86'){
            $vote = 1;
            $voces = new \Brbr\Model\Orm\Voices();
            \RS\Db\Adapter::sqlExec('INSERT INTO '. $voces->_getTable() . ' (site_id, work_id, category, user_ip, vote) VALUES ('.$site_id.', '.$id.', '.$category.', "'.$user_ip.'", '.$vote.')')->fetchAll();
        }
        else {
            $vote = 1;
            $voces = new \Brbr\Model\Orm\Voices();
            \RS\Db\Adapter::sqlExec('INSERT INTO '. $voces->_getTable() . ' (site_id, work_id, category, user_ip, vote) VALUES ('.$site_id.', '.$id.', '.$category.', "'.$user_ip.'", '.$vote.')')->fetchAll();
        }
        return $this->result->setSuccess(true);
    }
}