<?php

use yii\db\Migration;

class m160419_072714_create_notice extends Migration
{
    public function up()
    {
        $this->createTable('notice', [
            'id' => $this->primaryKey(),
            'title'=> $this->string(100)->notNull(),
            'description'=> $this->string(150)->notNull(),
            'date'=> $this->timestamp(),
            'user_from' => $this->integer(11)->notNull(),
            'read' => $this->smallInteger(1)->defaultValue(0),
            'user_id' => $this->integer(11)->notNull(),
        ]);
        
         $this->insert('notice', [
            'title'=> 'Уважаемый admin. На сайте http://yii2-sergkrsn-master.com/web/index.php добавлена статья',
            'description'=> 'Сделан еще один шаг к развязке лицемерного спектакля власти, - Балога...<a href="/web/index.php?r=article%2Fview&amp;id=3">читать далее</a>',            
            'user_from'=> 1,
            'user_id'=> 1,
            
        ]);
        $this->insert('notice', [
            'title'=> 'Уважаемый user 1. На сайте http://yii2-sergkrsn-master.com/web/index.php добавлена статья',
            'description'=> 'Сделан еще один шаг к развязке лицемерного спектакля власти, - Балога...<a href="/web/index.php?r=article%2Fview&amp;id=3">читать далее</a>',            
            'user_from'=> 1,
            'user_id'=> 2,
            
        ]);
        
        $this->insert('notice', [
            'title'=> 'Уважаемый user 2. На сайте http://yii2-sergkrsn-master.com/web/index.php добавлена статья',
            'description'=> 'Сделан еще один шаг к развязке лицемерного спектакля власти, - Балога...<a href="/web/index.php?r=article%2Fview&amp;id=3">читать далее</a>',            
            'user_from'=> 1,
            'user_id'=> 3,
            
        ]);         
         
                 
    }

    public function down()
    {
        $this->dropTable('notice');
    }
}
