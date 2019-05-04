<?php

/**
 * @copyright ev-lab.ru
 * @license 
 */

namespace evSourceBuster\Model;

use \RS\Orm\Type;

/**
 * Класс работы с UTM метками
 */
class Utm
{
     public static function getSourceAuto($utmsource)
    {
        $config = \RS\Config\Loader::byModule('evsourcebuster');

        $rules = array (
            'typein' => 'Прямой переход',
            'utm' => 'Реклама',
            'referral' => 'Внешняя ссылка',
            'organic' => 'Поиск'
          );

        $utmsource = json_decode($utmsource, true);
        
        $utm = static::utm2array($utmsource['utm_first']);
        $utm_current = static::utm2array($utmsource['utm_current']);
        $find = array(); 
        $find['first'] = array('name' => '', 'code' => '', 'utm' => $utm);
        $find['current'] = array('name' => '', 'code' => '', 'utm' => $utm);
        
        $find['first']['name'] = $rules[$utm["typ"]];
        $find['current']['name'] = $rules[$utm_current["typ"]];
                
        return $find;
    }
    public static function getSource($utmsource)
    {
        $config = \RS\Config\Loader::byModule('evsourcebuster');

        $rules = explode(';', htmlspecialchars_decode($config->utm_source));

        $utmsource = json_decode($utmsource, true);

        $utm = static::utm2array($utmsource['utm_first']);

        $find = array('name' => '', 'code' => '', 'utm' => $utm);

        $found = false;

        foreach ($rules as $rule) {
            $rule = json_decode($rule, true);
            // подсказка
            // {"utm_first":"typ=utm|||src=yandex|||mdm=cpc|||cmp=13348812|||cnt=1001350565|||trm=%D0%BA%D0%BE%D0%BD%D1%82%D0%B0%D0%BA%D1%82%D0%BD%D1%8B%D0%B5%20%D0%BB%D0%B8%D0%BD%D0%B7%D1%8B%20%D0%B2%20%D0%BA%D0%B5%D0%BC%D0%B5%D1%80%D0%BE%D0%B2%D0%BE","utm_current":"typ=utm|||src=yandex|||mdm=cpc|||cmp=13348812|||cnt=1001350565|||trm=%D0%BA%D0%BE%D0%BD%D1%82%D0%B0%D0%BA%D1%82%D0%BD%D1%8B%D0%B5%20%D0%BB%D0%B8%D0%BD%D0%B7%D1%8B%20%D0%B2%20%D0%BA%D0%B5%D0%BC%D0%B5%D1%80%D0%BE%D0%B2%D0%BE"}
            if (!$found &&                                                          
                    (($rule["type"] == $utm["typ"]) || ($rule["type"] == "")) &&
                    (($rule["source"] == $utm["src"]) || ($rule["source"] == "")) &&
                    (($rule["medium"] == $utm["mdm"]) || ($rule["medium"] == "")) &&
                    (($rule["campaign"] == $utm["cmp"]) || ($rule["campaign"] == ""))
            ) {
                $find['name'] = $rule['name'];
                $find['code'] = $rule['code'];
                $found = true;
            }
        }

        return $find;
    }   
    
   
    private static function utm2array($utm)
    {
        $result = array();
        $utm = explode('|||', $utm);
        foreach ($utm as $value) {
            $temp = explode('=', $value);
            $result[$temp[0]] = $temp[1];
        }
        return $result;
    }

}
