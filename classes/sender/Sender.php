<?php
namespace app\classes\sender;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Description of Sender
 *
 * @author serg
 */
abstract class Sender {
    
    private $replace_params;
    
    abstract public function send($Notification); 
    
    public function fillArrayReplace($model) {
        
        if ($model instanceof \app\models\Article) {
            $this->replace_params =['{articleName}' =>$model->title , 
                                    '{shortText}' => $model->shorttext,
                                      '{href}' => Html::a('читать далее', ['view', 'id' => $model->id]),
                                      '{sitename}'=>Url::home(TRUE)];
        }  else {
            $this->replace_params['{username}']=$model->name; 
        }     
        
    }
    
    public function replace($text) {
        return str_replace( array_keys($this->replace_params), array_values($this->replace_params), $text);
    }
    
    

}


