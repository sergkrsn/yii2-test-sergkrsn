<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "notice".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $date
 * @property integer $user_from
 * @property integer $read
 * @property integer $user_id
 */
class Notice extends \yii\db\ActiveRecord
{
    const NOREAD=0;
    const READ=1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'user_from', 'user_id'], 'required'],
           // [['date'], 'safe'],
            [['user_from', 'read', 'user_id'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 150]
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
            'description' => 'Description',
            'date' => 'Date',
            'user_from' => 'User From',
            'read' => 'Read',
            'user_id' => 'User ID',
        ];
    }
    public function classCss() {
        if ($this->read == self::READ) {
            return 'alert-info';
        } else {
            return 'alert-warning';
        }
    }
    
    public function getUserFromName() {
        return User::findOne($this->user_from)->name;
        
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
