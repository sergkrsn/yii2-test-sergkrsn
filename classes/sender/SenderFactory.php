<?php
//namespace classes\sender;
namespace app\classes\sender;

//use app\classes\sender\Browser;
//use app\classes\sender\Email;

/**
 * Description of SenderFactory
 *
 * @author serg
 */
class SenderFactory {    

    public static function build ($type = '') {

        if($type == '') {
            throw new \yii\base\Exception('Invalid Type.');
        } else {

            $className = '\app\classes\sender\\'.ucfirst($type);
            // проверка существования класса
            if(class_exists($className)) {                        
                return new $className();
            } else {
                throw new \yii\base\Exception('type sender not found - '.$className);
            }
        }
    }
}
