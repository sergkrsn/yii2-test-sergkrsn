<?php

namespace app\models;

use Yii;
use app\models\Notification;
use app\models\Notice;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $name
 * @property string $email
 * @property string $status
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const EVENT_DISABLE_USER = 'disable-user';
    const STATUS_DISABLE = 'disable';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
  public function rules()
    {
        return [
            [['username', 'password','name','email'], 'required'],
            [['status'], 'string'],
            [['username', 'email'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 10],
            [['authKey'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'name' => 'Name',
            'email' => 'Email',
            'status' => 'Status',
        ];
    }
        
    public function getAuthKey() {
        return $this->authKey;
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
      return $this->getAuthKey() === $authKey;   
    }

    public static function findIdentity($id) {
        return static::findOne($id);        
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                //print_r($this);
                $this->authKey = \Yii::$app->security->generateRandomString();                                
            }
            return true;
        }
        return false;
    }
    
    public static function findByUsername($username)
    {
        return static::findOne(array('username'=>$username));
    }
    
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
    
    private function setNotificationOnEvents(){
               
        $notifications = Notification::selectforUser();        
        foreach ($notifications as $notif) {  
            $this->on($notif->getEvent()->One()->getName(),[$notif, 'send']);
        }        
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function init() {
        parent::init();
        $this->setNotificationOnEvents();    
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if (!($insert)) {            
            if ((isset($changedAttributes['status'])) && ($this->status == self::STATUS_DISABLE)) {
                $this->trigger(self::EVENT_DISABLE_USER);
            }
        }        
    }    
    
    public function getNotices()
    {
        return $this->hasMany(Notice::className(), ['user_id' => 'id']);
    }
   
    
//    public function isAdmin() {        
//        return ($this->id==1); 
//    }
//        
//    public function sendNotification() {
//        echo '!!!!! XAXAXAXA';
//    }
//    public function save($param) {
//        parent::EVENT_AFTER_INSERT;
//        echo '!!!! save';
//        
////        print_r($param);
////        exit;
//    }
}
