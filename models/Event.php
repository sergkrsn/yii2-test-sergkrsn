<?php

namespace app\models;

use Yii;
use app\models\Notification;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $type_object
 */
class Event extends \yii\db\ActiveRecord
{
    private $replaceInfo = ['user' => ['{username}' => 'имя пользователя', '{user_id}' => 'код пользователя'],
        'post' => ['{username}' => 'имя пользователя','{articleName}' => 'заголовок статьи', '{shortText}' => 'короткий текст', '{href}' => 'ссылка на статью', '{sitename}'=>'название сайта']];
    
    public function getReplaceInfo() {   
        foreach ($this->replaceInfo[$this->type_object] as $key => $value) {
               $str.=$key . '=' . $value . '; ';
            }
        return $str;       
    }

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'type_object'], 'required'],
            [['type_object'], 'string'],
            [['name'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'type_object' => 'Type Object',
        ];
    }
    
    
    public function getName() {
        return $this->name;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getNotifications()
    {
        return $this->hasMany(Notification::className(), ['event_id' => 'id']);
    }
}
