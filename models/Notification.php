<?php

namespace app\models;

use Yii;
use app\models\Event;
use app\classes\sender\SenderFactory;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property string $name
 * @property integer $event_id
 * @property integer $from_user_id
 * @property integer $whom_user_id
 * @property string $title
 * @property string $description
 * @property string $type
 */
class Notification extends \yii\db\ActiveRecord {

    private $usersTo;    
    private $article;
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'event_id', 'from_user_id', 'title', 'type'], 'required'],
            [['event_id', 'from_user_id', 'whom_user_id'], 'integer'],
            [['type'], 'ArrayToString'],
            [['name'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 80],
            [['description'], 'string', 'max' => 150]
        ];
    }

    public function ArrayToString($attribute, $model) {
        if (is_array($this->$attribute)) {
            $this->$attribute = implode(',', $this->$attribute);
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getEvent() {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }

    public function getUserFromName() {
        return User::findIdentity($this->from_user_id)->username;
    }

    public function getUserWhomName() {
        if (Event::findOne($this->event_id)->type_object=='user'){
            return 'current';
        }        
        if ($this->whom_user_id == NULL) {            
            return 'all users';
        } else {
            return User::findIdentity($this->whom_user_id)->username;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'event_id' => 'Event',
            'from_user_id' => 'From User',
            'whom_user_id' => 'Whom User',
            'title' => 'Title',
            'description' => 'Description',
            'type' => 'Type',
        ];
    }

    static public function selectforUser() {
        return self::find()
                        ->joinWith('event')
                        ->where(['event.type_object' => 'user'])
                        ->all();
    }
    
    static public function selectforArticle() {
        return self::find()
                        ->joinWith('event')
                        ->where(['event.type_object' => 'post'])
                        ->all();
    }
    
    public function setMailsTo($user) {
        if (is_null($user)){
            $this->usersTo = User::find()->all();
        } else {
            $this->usersTo = [$user];
        }
        
    }

    public function getMailsTo() {
        return $this->usersTo;
    }

    public function send($event) {
        
        if ($event->sender instanceof User){
            $user = $event->sender;            
        }  else {
            $this->article = $event->sender;
            $user = User::findIdentity($this->whom_user_id);            
        }        
        $this->setMailsTo($user);        
        
        $arr = explode(',', $this->type);
        foreach ($arr as $val) {
            $sender = SenderFactory::build($val);        
            $sender->send($this);
        }
    }

    static function getTypesDelivery() {
        return ['email' => 'email', 'browser' => 'browser', 'sms' => 'sms'];
    }

    public function getSelectedTypesToForm() {

        $arr = explode(',', $this->type);
        foreach ($arr as $val) {
            $res[$val] = ['Selected' => true];
        }
        return $res;
    }
    
    public function getReplaceInfo() {
        
        $event = Event::findOne($this->event_id);
        if (!is_null($event)) {
            return $event->getReplaceInfo();
        }
            
    }
    
    public function getArticle() {
        return $this->article;
    }
//    public function beforeValidate($param) {        
//    }
}
