<?php

use yii\db\Migration;

class m160418_093948_create_user extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username'=> $this->string(30)->notNull(),
            'password'=> $this->string(10)->notNull(),
            'authKey'=> $this->string(10)->notNull(),
            'name'=> $this->string(50)->notNull(),
            'email'=> $this->string(30)->notNull(),
            'status'=>"enum('new','active','disable') NOT NULL DEFAULT 'new'",
        ]);
        
        $this->insert('user', [
            'username'=> 'admin',
            'password'=> '123',
            'authKey'=> 'admin',
            'name'=> 'admin',
            'email'=> 'admin@mail.com',
            'status'=>'active'
        ]);
         
        $this->insert('user', [
            'username'=> 'user_1',
            'password'=> '123',
            'authKey'=> 'user 1',
            'name'=> 'user 1',
            'email'=> 'user_1@mail.com',
            'status'=>'active'
        ]);
         
         $this->insert('user', [
            'username'=> 'user_2',
            'password'=> '123',
            'authKey'=> 'user 2',
            'name'=> 'user 2',
            'email'=> 'user_2@mail.com',            
        ]);
        
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
