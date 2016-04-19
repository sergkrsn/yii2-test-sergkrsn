<?php

use yii\db\Migration;

class m160418_123839_create_notification extends Migration {

    public function up() {
        
        $this->createTable('event', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
            'description' => $this->string(50),
            'type_object' => "enum('user','post') NOT NULL",
        ]);
        
        $this->insert('event', [
            'name' => 'afterUpdate',
            'description' => 'обновление пользователя',
            'type_object' => 'user',
        ]);
        
        $this->insert('event', [
            'name' => 'afterInsert',
            'description' => 'добавление пользователя',
            'type_object' => 'user',
        ]);
        
        $this->insert('event', [
            'name' => 'afterInsert',
            'description' => 'добавление статьи',
            'type_object' => 'post',
        ]);
        
        $this->insert('event', [
            'name' => 'disable-user',
            'description' => 'блокирование пользователя',
            'type_object' => 'user',
        ]);
        
        $this->insert('event', [
            'name' => 'afterUpdate',
            'description' => 'обновление статьи',
            'type_object' => 'post',
        ]);
        
        
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'event_id' => $this->integer(5)->notNull(),
            'from_user_id' => $this->integer(11)->notNull(),
            'whom_user_id' => $this->integer(11)->defaultValue(NULL),
            'title' => $this->string(80)->notNull(),
            'description' => $this->string(150),
            'type' => $this->string(60),
        ]);

        $this->insert('notification', [
            'name' => 'Оповещение при регистрации пользователя',
            'event_id' => 2,
            'from_user_id' => 1,
            'whom_user_id' => NULL,
            'title' => 'Вы успешно зарегистрированны',
            'description' => 'Перейдите по ссылке...',
            'type' => 'browser,email',
        ]);
        
        $this->insert('notification', [
            'name' => 'Пользователь заблокирован',
            'event_id' => 4,
            'from_user_id' => 1,
            'whom_user_id' => NULL,
            'title' => 'Dear {username} you have been block',
            'description' => 'Dear {username} you have been block',
            'type' => 'browser,email',
        ]);
        
        $this->insert('notification', [
            'name' => 'Добавление статьи',
            'event_id' => 5,
            'from_user_id' => 1,
            'whom_user_id' => NULL,
            'title' => 'Уважаемый {username}. На сайте {sitename} добавлена статья',
            'description' => '{shortText}...{href}',
            'type' => 'browser,email',
        ]);
    }

    public function down() {
        $this->dropTable('notification');
    }

}
