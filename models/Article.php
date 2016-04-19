<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $shorttext
 * @property string $text
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'shorttext', 'text'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['shorttext'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'shorttext' => 'Shorttext',
            'text' => 'Text',
        ];
    }
     private function setNotificationOnEvents(){
               
        $notifications = Notification::selectforArticle();        
        foreach ($notifications as $notif) {  
            $this->on($notif->getEvent()->One()->getName(),[$notif, 'send']);
        }        
    }
    
    public function init() {
        parent::init();
        $this->setNotificationOnEvents();    
    }
}
