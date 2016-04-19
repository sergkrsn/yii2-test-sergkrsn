<?php

namespace app\classes\sender;
use app\models\User;
use app\models\Notice;

/**
 * Description of Browser
 *
 * @author serg
 */
class Browser extends Sender {
    const NO_READ =0;
    public function send($Notification) {
        $userFrom = User::findIdentity($Notification->from_user_id);
        $userTo = $Notification->getMailsTo();
        $this->fillArrayReplace($Notification->getArticle());
        foreach ($userTo as $user) {
            $this->fillArrayReplace($user);
            
            $notice = new Notice();
            $notice->title = $this->replace($Notification->title);
            $notice->description = $this->replace($Notification->description);            
            $notice->read = self::NO_READ;
            $notice->user_id = $user->getId(); 
            $notice->user_from = $userFrom->getId();
            //print_r($notice);
            if(!$notice->save())
                print_r($notice->getErrors());            
            
            
        }
    }
}
