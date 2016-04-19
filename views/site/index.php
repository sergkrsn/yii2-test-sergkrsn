<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\grid\GridView;
use yii\bootstrap\Alert;
use yii\bootstrap\Button;
use yii\bootstrap\Html;

$this->title = 'Sergkrsn test Application';
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Notification </p>

    </div>

    <div class="body-content">
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'tag' => 'div',
                'class' => 'list-wrapper',
                'id' => 'list-wrapper',
            ],
            'layout' => "{pager}\n{items}\n{summary}",
            'itemView' => function ($model, $key, $index, $widget) {
        return Alert::widget([
                    'options' => [
                        'class' => $model->classCss()
                    ],
                    'body' => '<b>' . $model->title . '</b>&nbsp&nbsp-' . $model->getUserFromName().'&nbsp'.$model->date .
                    '<br/>' . $model->description .
                    Button::widget([
                    'label' => 'прочитал',
                    'options' => [
                    'class' => 'btn-primary',
                    'style' => 'margin:5px',
                    'onclick' => 'markRead(event,'.$model->id.')'    
                    ]])                    
        ]);
    },
            'pager' => [
                'firstPageLabel' => 'first',
                'lastPageLabel' => 'last',
                'nextPageLabel' => 'next',
                'prevPageLabel' => 'previous',
                'maxButtonCount' => 3,
            ],
        ]);    
        ?>
    </div>
</div>
<script>
    function markRead(event,id){
       $.ajax({
             type  :'POST',             
             url  : '?r=notice/read/&id='+id,
             success  : function(response){
                     if (response){                        
                         blockAlert= $("div[data-key ="+id+"] :first-child").removeClass('alert-warning').addClass('alert-info');
                     }
                     
                     return false;}
               });        
    }
    
</script>