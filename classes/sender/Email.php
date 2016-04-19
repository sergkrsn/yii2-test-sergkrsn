<?php

namespace app\classes\sender;
use app\models\User;
use Yii;

/**
 * Description of Mail
 *
 * @author serg
 */
class Email extends Sender {
 

    public function send($Notification) {
        //echo 'send by mail';
        $userFrom = User::findIdentity($Notification->from_user_id);
        $userTo = $Notification->getMailsTo();
        $this->fillArrayReplace($Notification->getArticle());
        foreach ($userTo as $user) {
            $this->fillArrayReplace($user);
            Yii::$app->mailer->compose()
                    ->setFrom($userFrom->getEmail())
                    ->setTo($user->getEmail())
                    ->setSubject($this->replace($Notification->title))
                    ->setTextBody($this->replace($Notification->description))                            
                    ->send();
        }

    }

}
